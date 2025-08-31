ORIGINAL
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
    capsLock: false
  },

  init() {
    this.elements.main = document.createElement("div");
    this.elements.keysContainer = document.createElement("div");

    this.elements.main.classList.add("keyboard", "keyboard-hidden","d-none","d-md-block");
    this.elements.keysContainer.classList.add("keyboard-keys");
    this.elements.keysContainer.appendChild(this._createKeys());

    this.elements.keys = this.elements.keysContainer.querySelectorAll(
        ".keyboard-key"
    );

    this.elements.main.appendChild(this.elements.keysContainer);
    document.body.appendChild(this.elements.main);

    // Variable para el input activo
    this.activeInput = null;

    document.querySelectorAll(".keyboard-input").forEach((element) => {
        element.addEventListener("focus", () => {
            this.activeInput = element; // Guardar el input activo
            this.open(element.value, (currentValue) => {
                element.value = currentValue;
            });
        });
    });
},

_createKeys() {
    const fragment = document.createDocumentFragment();
    const keyLayout = [
      "1",
      "2",
      "3",
      "4",
      "5",
      "6",
      "7",
      "8",
      "9",
      "0",
      "backspace",
      "q",
      "w",
      "e",
      "r",
      "t",
      "y",
      "u",
      "i",
      "o",
      "p",
      // "caps",
      "a",
      "s",
      "d",
      "f",
      "g",
      "h",
      "j",
      "k",
      "l",
      // "enter",
      "ñ",
      "done",
      "z",
      "x",
      "c",
      "v",
      "b",
      "n",
      "m",
      ",",
      ".",
      "@",
      "space"
    ];

    const createIconHTML = (icon_name) => {
        return `<i class="material-icons">${icon_name}</i>`;
    };

    keyLayout.forEach((key) => {
        const keyElement = document.createElement("button");
        const insertLineBreak = ["backspace", "p", "done", "@"].indexOf(key) !== -1;

        keyElement.classList.add("keyboard-key");

        keyElement.addEventListener("pointerdown", () => {
            // Validar restricciones según la clase del input activo
            if (this.activeInput) {
                const isOnlyNumber = this.activeInput.classList.contains("onlyNumber");
                const isOnlyLetters = this.activeInput.classList.contains("onlyLetters");

                // Verificar condiciones para números y letras
                if (isOnlyNumber && !key.match(/^\d$/) && key !== "backspace" && key !== "done") {
                    return; // Permitir solo números
                }

                if (isOnlyLetters && !key.match(/^[a-zA-ZñÑ]$/) && key !== "done" && key !== "backspace" && key !== "space") {
                    return; // Permitir solo letras y espacio
                }
            }

            // Procesar tecla presionada
            switch (key) {
                case "backspace":
                    this.properties.value = this.properties.value.slice(0, -1);
                    break;
                case "space":
                    this.properties.value += " ";
                    break;
                case "done":
                    this.close();
                    this._triggerEvent("onclose");
                    break;
                default:
                    this.properties.value += key;
                    break;
            }

            this._triggerEvent("oninput");
        });

        // Asignar contenido de la tecla
        if (key === "backspace") {
            keyElement.innerHTML = createIconHTML("backspace");
            keyElement.classList.add("keyboard-wide");
        } else if (key === "space") {
            keyElement.innerHTML = createIconHTML("space_bar");
            keyElement.classList.add("keyboard-extrawide");
        } else if (key === "done") {
            keyElement.innerHTML = createIconHTML("check_circle");
            keyElement.classList.add("keyboard-wide", "keyboard-dark");
        } else {
            keyElement.textContent = key;
        }

        fragment.appendChild(keyElement);

        if (insertLineBreak) {
            fragment.appendChild(document.createElement("br"));
        }
    });

    return fragment;
},

  _triggerEvent(name) {
    if (typeof this.eventHandlers[name] === "function") {
      this.eventHandlers[name](this.properties.value);
    }
  },

  _toggleCapsLock() {
    this.properties.capsLock = !this.properties.capsLock;

    for (const key of this.elements.keys) {
      if (key.childElementCount === 0) {
        key.textContent = this.properties.capsLock
          ? key.textContent.toUpperCase()
          : key.textContent.toLowerCase();
      }
    }
  },

  open(initialValue, oninput, onclose) {
    this.properties.value = initialValue || "";
    this.eventHandlers.oninput = oninput;
    this.eventHandlers.onclose = onclose;
    this.elements.main.classList.remove("keyboard-hidden");
  },

  async close() {
    this.properties.value = "";
    this.eventHandlers.oninput = oninput;
    this.eventHandlers.onclose = onclose;
    this.elements.main.classList.add("keyboard-hidden");
    console.log(7);
    if(buscarUsuarioFlag){
        await buscarUsuario();
    }else{
        if(puedeEnviar){
            await enviarLinkMailPago();
        }
    }
  }
};

Keyboard.init();