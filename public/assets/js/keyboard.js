const Keyboard = {
  elements: {
    main: null,
    keysContainer: null,
    keys: []
  },

  eventHandlers: {
    oninput: null,
    onclose: null
  },

  properties: {
    value: "",
    capsLock: false,
    cursorPosition: 0
  },

  init() {
    this.elements.main = document.createElement("div");
    this.elements.keysContainer = document.createElement("div");

    this.elements.main.classList.add("keyboard", "keyboard-hidden", "d-none", "d-md-block");
    this.elements.keysContainer.classList.add("keyboard-keys");
    this.elements.main.appendChild(this.elements.keysContainer);
    document.body.appendChild(this.elements.main);

    // Variable para el input activo
    this.activeInput = null;

    document.querySelectorAll(".keyboard-input").forEach((element) => {
      element.addEventListener("focus", () => {
        this._handleFocus(element)
        // this.activeInput = element; // Guardar el input activo
        // this.properties.value = element.value; // Sincronizar valor
        // this.properties.cursorPosition = element.selectionStart; // Posición del cursor
        // this._renderKeys();
        // this.open(element.value, (currentValue) => {
        //   element.value = currentValue;
        // });
      });

      element.addEventListener("click", () => {
        if (this.activeInput) {
          this.properties.cursorPosition = element.selectionStart; // Actualizar posición del cursor
        }
      });
    });
  },

  _renderKeys() {
    this.elements.keysContainer.innerHTML = ""; // Limpiar teclas existentes

    const keyLayout = this.activeInput?.classList.contains("onlyNumber")
      ? ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "backspace", "done"]
      : [
          "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "backspace",
          "q", "w", "e", "r", "t", "y", "u", "i", "o", "p", "+",
          "a", "s", "d", "f", "g", "h", "j", "k", "l",
          "ñ", "done", "z", "x", "c", "v", "b", "n", "m", ".", "-", "_", "@", "space"
        ];

    keyLayout.forEach((key) => {
      const keyElement = document.createElement("button");
      const insertLineBreak = this.activeInput?.classList.contains("onlyNumber") 
      ? ["3", "6", "9"].indexOf(key) !== -1 
      : ["backspace", "+", "done", "@"].indexOf(key) !== -1;

      keyElement.classList.add("keyboard-key");

      // pointerdown
      // keyElement.addEventListener("touchstart", () => {
      //   this._handleKeyPress(key);
      // });

      /*const eventType = "ontouchstart" in window ? "touchstart" : "click";

      keyElement.addEventListener(eventType, (event) => {
        event.preventDefault();
        event.stopPropagation();
        this._handleKeyPress(key);
      });*/

      keyElement.addEventListener("pointerdown", () => {
        this._handleKeyPress(key);
      });
      
      // Asignar contenido de la tecla
      if (key === "backspace") {
        keyElement.innerHTML = `<i class="material-icons">backspace</i>`;
        if(!this.activeInput?.classList.contains("onlyNumber")){
            keyElement.classList.add("keyboard-wide");
        }
      } else if (key === "space") {
        keyElement.innerHTML = `<i class="material-icons">space_bar</i>`;
        keyElement.classList.add("keyboard-extrawide");
      } else if (key === "done") {
        keyElement.innerHTML = `<i class="material-icons">check_circle</i>`;
        if(!this.activeInput?.classList.contains("onlyNumber")){
            keyElement.classList.add("keyboard-wide", "keyboard-dark");
        }else{
            keyElement.classList.add("keyboard-dark");
        }
      } else {
        keyElement.textContent = key;
      }

      this.elements.keysContainer.appendChild(keyElement);

      if (insertLineBreak) {
        this.elements.keysContainer.appendChild(document.createElement("br"));
      }
    });
  },

  _simulateFocus(inputId) {
    const element = document.getElementById(inputId); // Obtener el input por ID
    if (element) {
      element.focus(); // Forzar el enfoque en el input
      this._handleFocus(element); // Llamar a la función que maneja el evento focus
    } else {
      console.error(`No se encontró el elemento con ID: ${inputId}`);
    }
  },

  _handleKeyPress(key) {
    if (this.activeInput) {
      const start = this.properties.cursorPosition;
      const end = this.properties.cursorPosition;

      switch (key) {
        case "backspace":
          if (start > 0) {
            this.properties.value =
              this.properties.value.slice(0, start - 1) + this.properties.value.slice(end);
            this.properties.cursorPosition = start - 1;
          }
          break;
        case "space":
          this.properties.value =
            this.properties.value.slice(0, start) + " " + this.properties.value.slice(end);
          this.properties.cursorPosition = start + 1;
          break;
        case "done":
          this.close();
          this._triggerEvent("onclose");
          return;
        default:
          this.properties.value =
            this.properties.value.slice(0, start) + key + this.properties.value.slice(end);
          this.properties.cursorPosition = start + 1;
          break;
      }

      this.activeInput.value = this.properties.value;
      this.activeInput.setSelectionRange(this.properties.cursorPosition, this.properties.cursorPosition);
      this._triggerEvent("oninput");
    }
  },

  _triggerEvent(name) {
    if (typeof this.eventHandlers[name] === "function") {
      this.eventHandlers[name](this.properties.value);
    }
  },

  _handleFocus(element) {
    console.log(99); // Para verificar que el evento focus se activó
    this.activeInput = element; // Guardar el input activo
    this.properties.value = element.value; // Sincronizar valor
    this.properties.cursorPosition = element.selectionStart; // Posición del cursor
    this._renderKeys();
    this.open(element.value, (currentValue) => {
      element.value = currentValue;
    });
  },

  open(initialValue, oninput, onclose) {
    this.properties.value = initialValue || "";
    this.eventHandlers.oninput = oninput;
    this.eventHandlers.onclose = onclose;
    this.elements.main.classList.remove("keyboard-hidden");
  },

  async close(type = null) {
    this.properties.value = "";
    this.properties.cursorPosition = 0;
    this.activeInput = null;
    this.eventHandlers.oninput = null;
    this.eventHandlers.onclose = null;
    this.elements.main.classList.add("keyboard-hidden");
    if(type == null){
        if(buscarUsuarioFlag){
            await buscarUsuario();
        }else{
            if(puedeEnviar){
                await enviarLinkMailPago();
            }
        }
    }else{
        console.log('do nothing but close keyboard');
    }
  }
};

Keyboard.init();
