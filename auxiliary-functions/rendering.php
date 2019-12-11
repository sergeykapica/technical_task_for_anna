<?

class Rendering
{
	public function renderPage($page, $declaredVariables = false)
	{
        if($declaredVariables != false)
        {
            // declare variables for view
            
            if(isset($this->defaultVariablesForRendering))
            {
                $declaredVariables = array_merge($declaredVariables, $this->defaultVariablesForRendering);
            }
            
            foreach($declaredVariables as $variableName => $variableValue)
            { 
                $$variableName = $variableValue;
            }
        }
        else
        {
            if(isset($this->defaultVariablesForRendering))
            {
                foreach($this->defaultVariablesForRendering as $variableName => $variableValue)
                { 
                    $$variableName = $variableValue;
                }
            }
        }
        
        // include header
        
        include_once($_SERVER['DOCUMENT_ROOT'] . '/views/static/header.php');
        
        // include page
        
		include_once($_SERVER['DOCUMENT_ROOT'] . '/views/' . $page . '.php');
        
        // include footer
        
        include_once($_SERVER['DOCUMENT_ROOT'] . '/views/static/footer.php');
	}
    
    public function renderHTML($path, $variables = false)
    {
        ob_start();
        
        include_once($_SERVER['DOCUMENT_ROOT'] . $path);
        
        return ob_get_clean();
    }
}
?>