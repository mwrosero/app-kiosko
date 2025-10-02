(function($){

    var CustomKeyboard = {
        targetInput: null,
        layout: [],
        lastKeyTime: 0,
        keyDelay: 200,
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
                ['Z','X','C','V','B','N','M','_','-','.'],
                ['Space']
            ],
            alphabet: [
                ['Q','W','E','R','T','Y','U','I','O','P','Backspace'],
                ['A','S','D','F','G','H','J','K','L','Ñ','Enter'],
                ['Z','X','C','V','B','N','M'],
                ['Space']
            ],
            full: [
                ['1','2','3','4','5','6','7','8','9','0','Backspace'],
                ['Q','W','E','R','T','Y','U','I','O','P'],
                ['A','S','D','F','G','H','J','K','L','Ñ','Enter'],
                ['Z','X','C','V','B','N','M','_','-','.'],
                ['@','!','#','$','%','&','*','(',')'],
                ['Space']
            ]
        },

        keyIcons: {
            'Backspace': '<i class="fa fa-backspace"></i>',
            'Space': '<span></span>',
            'Hidden': '',
            'Enter': '<i class="fa-solid fa-arrow-right"></i>'
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
                    // self.positionKeyboard(containerSelector);
                });
            });

            // Input con autofocus inicial
            var $auto = $(inputSelector + '[autofocus]');
            if($auto.length){
                self.targetInput = $auto;
                self.setLayoutFromInput();
                self.renderKeyboard(containerSelector);
                // self.positionKeyboard(containerSelector);
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
                    var $key = $(`<button type="button" class="kb-key kb-key-${key} btn border-midnight-blue ${stylesByLayout} rounded-8 fw-medium bg-white"></button>`);

                    // Si la tecla tiene icono, usar HTML del icono
                    $key.html(this.keyIcons[key] || key);

                    // $key.on('click touchstart', (e) => {
                    $key.on('pointerdown', (e) => {
                        if(e.cancelable) e.preventDefault();
                        let now = Date.now();
                        if(now - this.lastKeyTime > this.keyDelay){ 
                            this.lastKeyTime = now;
                            this.keyPress(key);
                        }
                    });

                    $row.append($key);
                });
                $kb.append($row);
            });
        },

        positionKeyboard: function(containerSelector){
            if(!this.targetInput) return;
            var $kb = $(containerSelector);
            var offset = this.targetInput.offset();
            var inputHeight = this.targetInput.outerHeight();

            // Posicionar justo sobre el input activo
            $kb.css({
                position:'absolute',
                top: offset.top - $kb.outerHeight() - 5, 
                left: offset.left
            });
        },

        keyPress: function(key){
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
                    this.targetInput.trigger('enter'); // si quieres un evento extra
                    break;
                default:
                    this.targetInput.val(val + key);
            }

            this.targetInput.trigger('input').trigger('change');
        }

    };

    $.customKeyboard = CustomKeyboard;

})(jQuery);