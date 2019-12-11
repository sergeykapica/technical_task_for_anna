(function()
{
    window.setDropDownMenu = function(buttons, popupMenuClass, buttonClass, hiddenInput, params = false)
    {
        var closeDuration = 2000;
        var timer;
        
        function openMenu(thisButton, popupMenu)
        {
            if(params != false)
            {
                if(thisButton.classList.contains(params.additionalMethods.classOfElement))
                {
                    params.additionalMethods.onopen(thisButton);
                }
            }
            
            popupMenu.style.zIndex = 2;
            popupMenu.style.opacity = 1;
            
            thisButton.openMenu = true;
        }
        
        function closeMenu(thisButton, popupMenu)
        {
            if(params != false)
            {
                if(thisButton.classList.contains(params.additionalMethods.classOfElement))
                {
                    params.additionalMethods.onclose(thisButton);
                }
            }
            
            popupMenu.style.zIndex = -1;
            popupMenu.style.opacity = 0;
            
            thisButton.openMenu = false;
        }
        
        for(let i = 0; i < buttons.length; i++)
        {
            buttons[i].onclick = function()
            {
                let thisButton = this;
                let popupMenu = thisButton.parentNode.querySelector('.' + popupMenuClass);
                
                if(thisButton.openMenu === undefined)
                {
                    thisButton.openMenu = false;
                }
                
                if(thisButton.openMenu === false)
                {
                    openMenu(thisButton, popupMenu);
                }
                else
                {
                    closeMenu(thisButton, popupMenu);
                }
            }; 
            
            buttons[i].onmouseout = function()
            {
                var thisButton = this;
                var popupMenu = thisButton.parentNode.querySelector('.' + popupMenuClass);
                
                timer = setTimeout(function()
                {
                    closeMenu(thisButton, popupMenu);
                }, closeDuration);
            };
            
            buttons[i].onmouseover = function()
            {
                if(timer !== undefined)
                {
                    clearTimeout(timer);
                }
            };
            
            var popupMenu = buttons[i].parentNode.querySelector('.' + popupMenuClass);
            
            popupMenu.onmouseout = function()
            {
                let thisMenu = this;
                
                timer = setTimeout(function()
                {
                    closeMenu(thisMenu.parentNode.querySelector('.' + buttonClass), thisMenu);
                }, closeDuration);
            };
            
            popupMenu.onmouseover = function()
            {
                if(timer !== undefined)
                {
                    clearTimeout(timer);
                }
            };
            
            popupMenu.onclick = function(e)
            {
                let target = e.target;
                let thisPopup = this;
                
                if(target.nodeName == 'LI')
                {
                    let targetValue = target.innerText;
                    
                    buttons[i].innerText = targetValue;
                    buttons[i].parentNode.querySelector('.' + hiddenInput).value = targetValue;
                    
                    closeMenu(buttons[i], thisPopup);
                }
            };
        }
    };
})();