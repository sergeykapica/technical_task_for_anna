(function()
{
    window.initLoadPage = function()
    {
        window.onclick = function()
        {
            return false;
        };
        
        function definitionLoad()
        {
            window.onclick = null;
        };
        
        if(window.addEventListener !== undefined)
        {
            window.addEventListener('load', definitionLoad);
        }
        else
        {
            window.attachEvent('onload', definitionLoad);
        }
    };
})();