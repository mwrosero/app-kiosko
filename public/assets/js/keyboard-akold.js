(function($){

    var CustomKeyboard = {
        targetInput: null,
        layout: [],
        lastKeyTime: 0,
        keyDelay: 200,
        isUppercase: true,
        currentLayoutType: 'alphanumeric',

        layoutTypes: {
            numeric: [
                ['1','2','3'],
                ['4','5','6'],
                ['7','8','9'],
                ['Hidden','0','Backspace']
            ],
            alphanumeric: [
                ['1','2','3','4','5','6','7','8','9','0','Backspace'],
                ['Q','W','E','R','T','Y','U','I','O','P'],
                ['A','S','D','F','G','H','J','K','L','Ñ','Enter'],
                ['Shift','Z','X','C','V','B','N','M','_','-','.'],
                ['Space']
            ],
            alphabet: [
                ['Q','W','E','R','T','Y','U','I','O','P','Backspace'],
                ['A','S','D','F','G','H','J','K','L','Ñ','Enter'],
                ['Shift','Z','X','C','V','B','N','M'],
                ['Space']
            ],
            full: [
                ['1','2','3','4','5','6','7','8','9','0','Backspace'],
                ['Q','W','E','R','T','Y','U','I','O','P'],
                ['A','S','D','F','G','H','J','K','L','Ñ','Enter'],
                ['Shift','Z','X','C','V','B','N','M','_','-','.'],
                ['@','!','#','$','%','&','*','(',')'],
                ['Space']
            ]
        },

        keyIcons: {
            'Backspace': '<i class="fa fa-backspace"></i>',
            'Space': '<span></span>',
            'Hidden': '',
            'Enter': '<i class="fa-solid fa-arrow-right"></i>',
            'Shift': '⇧'
        },

        init: function(inputSelector, containerSelector){
            var self = this;

            // Inicializar contenedor
            var $container = $(containerSelector);
            $container.css({display:'block'}); // siempre visible

            // Detectar inputs
            $(inputSelector).off('focus touchstart').each(function(){
                $(this).attr('readonly', true);

                $(this).on('focus touchstart', function(e){
                    if(e.type === 'touchstart' && e.cancelable) e.preventDefault();
                    self.targetInput = $(this);
                    self.setLayoutFromInput();
                    self.renderKeyboard(containerSelector);
                });
            });

            // Input con autofocus inicial
            var $auto = $(inputSelector + '[autofocus]');
            if($auto.length){
                self.targetInput = $auto;
                self.setLayoutFromInput();
                self.renderKeyboard(containerSelector);
            }
        },

        setLayoutFromInput: function(){
            let type = this.targetInput.data('kb') || 'alphanumeric';
            this.layout = this.layoutTypes[type] || this.layoutTypes['alphanumeric'];
            this.currentLayoutType = type;
        },

        renderKeyboard: function(containerSelector){
            var $kb = $(containerSelector);
            $kb.empty();

            if(tecladoFlotante){
                $('#box-simple-keyboard').removeClass('d-none');
            }

            let stylesByLayout = 'py-2 m-1 fs-24 line-height-44';
            if(this.currentLayoutType == "numeric"){
                stylesByLayout = 'py-3 m-2 fs-36 line-height-44';
            }

            this.layout.forEach(row => {
                var $row = $('<div class="kb-row d-flex justify-content-center mb-1"></div>');

                row.forEach(key => {

                    // Ajuste de mayúsculas/minúsculas para visual
                    var displayKey = key;
                    if(!this.keyIcons[key] && /^[A-Z]$/i.test(key)){
                        var lowerKey = key.toLowerCase();
                        displayKey = this.isUppercase ? lowerKey.toUpperCase() : lowerKey;
                    }

                    // Clase consistente para el DOM (minúscula)
                    var keyClass = `kb-key-${key.toLowerCase()}`;

                    var $key = $(`<button type="button" class="kb-key ${keyClass} btn border-midnight-blue ${stylesByLayout} rounded-8 fw-medium bg-white"></button>`);

                    // Iconos o letra
                    $key.html(this.keyIcons[key] || displayKey);

                    // Resaltar Shift si activo
                    if(key === 'Shift'){
                        $key.toggleClass('active-shift', this.isUppercase);
                    }

                    // Evento pointerdown (touch + mouse)
                    $key.on('pointerdown', (e) => {
                        if(e.cancelable) e.preventDefault();
                        let now = Date.now();
                        if(now - this.lastKeyTime > this.keyDelay){ 
                            this.lastKeyTime = now;
                            this.keyPress(key, containerSelector);
                        }
                    });

                    $row.append($key);
                });

                $kb.append($row);
            });
        },

        keyPress: function(key, containerSelector){
            if(!this.targetInput) return;
            var val = this.targetInput.val();

            switch(key){
                case 'Backspace':
                    this.targetInput.val(val.slice(0,-1));
                    break;
                case 'Space':
                    this.targetInput.val(val + ' ');
                    break;
                case 'Enter':
                    this.targetInput.trigger('enter');
                    break;
                case 'Shift':
                    this.isUppercase = !this.isUppercase;
                    this.renderKeyboard(containerSelector); // redibuja con estado actualizado
                    return;
                    break;
                default:
                    var char = this.isUppercase ? key.toUpperCase() : key.toLowerCase();
                    this.targetInput.val(val + char);
            }

            this.targetInput.trigger('input').trigger('change');
        }

    };

    $.customKeyboard = CustomKeyboard;

})(jQuery);
