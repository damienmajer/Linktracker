<?php

/*
	========================================================
	Module: Linktracker
	--------------------------------------------------------
	Copyright: Damien Majer
	License: http://creativecommons.org/licenses/by-sa/3.0/
	http://www.damienmajer.com
	--------------------------------------------------------
	This addon may be used free of charge.
	--------------------------------------------------------
	EE 1 version by Oliver Heine http://utilitees.silenz.org
	========================================================
	File: mod.linktracker.php
	--------------------------------------------------------
	Purpose: Tracks clicks on any links that have an ID
             assigned. Shows number of clicks.
             Needs linktracker.js
	========================================================
	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF
	ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT 
	LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
	FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO 
	EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE
	FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN
	AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE 
	OR OTHER DEALINGS IN THE SOFTWARE.
	========================================================
*/

class Linktracker_mcp {
	
	var $module_name = "linktracker";	
    var $return_data	= ''; 
    var $base;	

    // -------------------------------------
    //  Constructor
    // -------------------------------------
    
    public function Linktracker_mcp()
    {
        $this->EE =& get_instance();

        $this->base = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module='.$this->module_name;
        
		/** -------------------------------
		/**  Is the module installed?
		/** -------------------------------*/
        
        $query = $this->EE->db->query("SELECT COUNT(*) AS count FROM exp_modules WHERE module_name = 'Linktracker'");
        
        if ($query->num_rows() == 0)
        {
        	return;
        }
        
        if ($this->EE->input->get('P') == "reset") $this->reset();

        if ($this->EE->input->get('P') == "detail") $this->detail();
        else $this->index();
    }

    /** -------------------------
    /**  Linktracker Home Page
    /** -------------------------*/
    
    public function index()
    {              
        $this->EE->cp->set_variable('cp_page_title', $this->EE->lang->line('linktracker_module_name'));

		$vars = array(); $clicks = array(); $label = array();

		$query = $this->EE->db->query("SELECT link_id,label FROM exp_linktracker;");

		if ($query->num_rows() != 0)
    	{
    		foreach($query->result_array() as $row)
    		{
				if ( !isset( $clicks[ $row['link_id'] ] ) ) {
					 $clicks[ $row['link_id'] ] = 1;
					 $label[ $row['link_id'] ] = $row['label'];
				}
				else
				{
					 $clicks[ $row['link_id'] ]++; 
				}
			}
    	}

    	arsort($clicks);

    	$vars['clicks'] = $clicks;
    	$vars['label'] = $label;

		return $this->EE->load->view('index', $vars, TRUE);

	}

	/** -------------------------
    /**  Linktracker Reset Link
    /** -------------------------*/
	
	function reset() {

		$this->EE->cp->set_variable('cp_page_title', $this->EE->lang->line('linktracker_reset'));
	 	$this->EE->cp->set_breadcrumb($this->base, $this->EE->lang->line('linktracker_module_name'));
	 	
 		$id = $this->EE->input->get('link_id');
 		$this->EE->db->query("DELETE FROM exp_linktracker WHERE link_id='$id';");

 		$vars = array();

 		return $this->EE->load->view('reset', $vars, TRUE);
	 		
	}

	/** -------------------------
    /**  Linktracker Detail Page
    /** -------------------------*/
	
	function detail() {
	 	
	 	$id = $this->EE->input->get('link_id');

	 	$this->EE->cp->set_variable('cp_page_title', $this->EE->lang->line('linktracker_link_detail'));
	 	$this->EE->cp->set_breadcrumb($this->base, $this->EE->lang->line('linktracker_module_name'));

    	$vars = array(); $clicks = array();
 		
 		$query = $this->EE->db->query("SELECT * FROM exp_linktracker WHERE link_id='$id' ORDER BY stamp DESC;");

 		$i = 0;

		foreach($query->result_array() as $row)
    	{
    		$clicks[$i]['id'] = date("Y-m-d H:i:s",$row['stamp']);
    		$clicks[$i]['label'] = $row['label'];
    		$clicks[$i]['target'] = $row['target'];
    		$clicks[$i]['url'] = $row['url'];
    		$clicks[$i]['ip'] = $row['ip'];	
    		$i++;				
		} 

		$vars['clicks'] = $clicks;

		return $this->EE->load->view('detail', $vars, TRUE);
	}
	
	   
}
?>