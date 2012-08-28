<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

class Linktracker {

    var $return_data = ''; 
		
	
	function Linktracker()
	{
		// Make a local reference to the ExpressionEngine super object
		$this->EE =& get_instance();

	}
		
	function addclick()
	{

		$ip = base64_decode($this->EE->input->get_post('uip'));
		$id = addslashes($this->EE->input->get_post('id'));
		$target = base64_decode($this->EE->input->get_post('target'));
		$url = base64_decode($this->EE->input->get_post('url'));
		$label = $this->EE->input->get_post('label');

		if (empty($id)) {
			header("Content-Type: text/xml; charset=utf-8\r\n");
			echo "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>\n";
			echo "<rsp stat=\"bot\" />";
			exit;
		}

		$view_count = array("vc1_","vc2_","vc3_","vc4_");
		if ( in_array(substr($id,0,4),$view_count) && is_numeric(trim(substr($id,4))) ) {
			
			switch (substr($id,0,4)) {
				case "vc1_":
				   $vc = "view_count_one";
        		break;
				case "vc2_":
				   $vc = "view_count_two";
        		break;
        		case "vc3_":
				   $vc = "view_count_three";
        		break;				
        		case "vc4_":
				   $vc = "view_count_four";
        		break;		        
			}

			$this->EE->db->query("UPDATE exp_channel_titles SET $vc=$vc+1 WHERE entry_id='".trim(substr($id,4))."';");

		}

		$timstamp = mktime();

		$data = array(
			'link_id' => $id,
			'stamp' => $timstamp,
			'target' => $target,
			'url' => $url,
			'label' => $label,
			'ip' => $ip
		);

		$this->EE->db->insert('exp_linktracker', $data);
	
		header("Content-Type: text/xml; charset=utf-8\r\n");
		echo "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>\n";
		echo "<rsp stat=\"ok\" />";
		exit;
		
	}

    function apiurl() 
    {
    		
    	$ip = base64_encode($this->EE->input->ip_address());
    	
    	$action_id = $this->EE->functions->fetch_action_id('Linktracker', 'addclick');
    	$apiurl = 'var actionurl = "'.$this->EE->functions->fetch_site_index().'?uip='.$ip.'&ACT='.$action_id.'&";'."\naddEvent(window, 'load', addLinkTracker, false);\n";
    	$apiurl = str_replace ("??","?",$apiurl);
    	
    	return $apiurl;
    	
    }

    function clicks() 
    {
    	
    	if ( !$this->EE->TMPL->fetch_param('link_id') ) return;
			$link_id = $this->EE->TMPL->fetch_param('link_id');
			$results = $this->EE->db->query("SELECT count(link_id) AS amount FROM exp_linktracker WHERE link_id='$link_id'");
			if ($results->num_rows() > 0)
			{
    			foreach($results->result_array() as $row)
    			{
    				$clicks = $row['amount'];
    			}
    		}	
			return 	$clicks;
					
    }
    
}    
// END CLASS

/* End of file mod.linktracker.php */
/* Location: ./system/expressionengine/modules/linktracker/mod.linktracker.php */