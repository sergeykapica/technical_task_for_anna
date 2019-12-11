(function()
{
    window.removeNodes = function(nodes)
    {
        for(let i = 0; i < nodes.length; i++)
        {
            nodes[i].parentNode.removeChild(nodes[i]);
        }
    };
})();