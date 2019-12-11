(function()
{
    function setPlaceholder(inputField, text, color)
    {
        inputField.style.color = color;
        
        if(inputField.getAttribute('type') == 'password')
        {
            inputField.setAttribute('type', 'text');
            inputField.passwordType = true;
        }
        
        if(inputField.value !== undefined)
        {
            inputField.value = text;
        }
        else
        {
            inputField.innerHTML = text;
        }
    }
    
    function unsetPlaceholder(inputField)
    {
        inputField.style.color = '';
        
        if(inputField.passwordType !== undefined)
        {
            inputField.setAttribute('type', 'password');
        }
        
        if(inputField.value !== undefined)
        {
            inputField.value = '';
        }
        else
        {
            inputField.innerHTML = '';
        }
    }
    
    window.setPlaceholderToInput = function(inputField, text, color)
    {
        if(inputField.value !== undefined)
        {
            if(inputField.value == '')
            {
                setPlaceholder(inputField, text, color);
            }

            inputField.onfocus = function()
            {
                if(this.value == '' || this.value == text)
                {
                    unsetPlaceholder(this);
                }
            };

            inputField.onblur = function()
            {
                if(this.value == '')
                {
                    setPlaceholder(this, text, color);
                }
            };
        }
        else
        {
            if(inputField.innerHTML == '')
            {
                setPlaceholder(inputField, text, color);
            }

            inputField.onfocus = function()
            {
                if(this.innerHTML == '' || this.innerHTML == text)
                {
                    unsetPlaceholder(this);
                }
            };

            inputField.onblur = function()
            {
                if(this.innerHTML == '')
                {
                    setPlaceholder(this, text, color);
                }
            };
        }
    };
})();