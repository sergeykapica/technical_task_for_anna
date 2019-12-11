(function()
{
    window.animate =
    {
        slideDown: function(element)
        {
            function animateElement()
            {
                element.style.height = element.originalHeight + 'px';
            }
            
            setTimeout(animateElement, 0);
        },
        
        slideUp: function(element)
        {
            function animateElement()
            {
                element.style.height = '0px';
            }
            
            setTimeout(animateElement, 0);
        }
    };
})();