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
	File: upd.linktracker.php
	--------------------------------------------------------
	Purpose: Installer/updater for mod.linktracker.php
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

class Linktracker_upd {

	var $version = '1.0';
	
	function Linktracker_upd()
	{
		// Make a local reference to the ExpressionEngine super object
		$this->EE =& get_instance();
	}


	// --------------------------------------------------------------------

	/**
	 * Module Installer
	 *
	 * @access	public
	 * @return	bool
	 */	
	function install()
	{
		$this->EE->load->dbforge();

		$data = array(
			'module_name' => 'Linktracker' ,
			'module_version' => $this->version,
			'has_cp_backend' => 'y'
		);

		$this->EE->db->insert('modules', $data);


		$data = array(
			'class'		=> 'Linktracker' ,
			'method'	=> 'addclick'
		);

		$this->EE->db->insert('actions', $data);


		$fields = array(
						'link_id'	=> array('type' 		 => 'varchar',
											'constraint'	 => '50',
											'default' 	     => '0'),
						'stamp'		=> array('type'			 => 'int',
											'constraint'	 => '10',
											'null' 			 => TRUE),
						'target'	=> array('type' 		 => 'varchar',
											'constraint'	 => '200',
											'null' 			 => TRUE),
						'url'		=> array('type' 		 => 'varchar',
											'constraint'	 => '200',
											'null' 			 => TRUE),
						'label'		=> array('type' 		 => 'varchar',
											'constraint'	 => '200',
											'null' 			 => TRUE),
						'ip'		=> array('type' 		 => 'varchar',
											'constraint'	 => '15',
											'default' 	     => '0.0.0.0')
						);

		$this->EE->dbforge->add_field($fields);

		$this->EE->dbforge->create_table('linktracker');

		return TRUE;

	}
	
	
	// --------------------------------------------------------------------

	/**
	 * Module Uninstaller
	 *
	 * @access	public
	 * @return	bool
	 */
	function uninstall()
	{
		$this->EE->load->dbforge();

		$this->EE->db->select('module_id');
		$query = $this->EE->db->get_where('modules', array('module_name' => 'Linktracker'));

		$this->EE->db->where('module_id', $query->row('module_id'));
		$this->EE->db->delete('module_member_groups');

		$this->EE->db->where('module_name', 'Linktracker');
		$this->EE->db->delete('modules');

		$this->EE->db->where('class', 'Linktracker');
		$this->EE->db->delete('actions');

		$this->EE->dbforge->drop_table('linktracker');

		return TRUE;
	}


	// --------------------------------------------------------------------

	/**
	 * Module Updater
	 *
	 * @access	public
	 * @return	bool
	 */	
	
	function update($current='')
	{
		return TRUE;
	}
	
}
/* END Class */

/* End of file upd.linktracker.php */
/* Location: ./system/expressionengine/third_party/modules/linktracker/upd.linktracker.php */