<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BotBuilder extends CI_Controller {

    private $tableData = array();
    private $result = array();

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'custom','botbuilder'));
        $this->load->model(array('common_model', 'bot_builder_model'));
        $this->load->library(array('session', 'user_agent'));
        $this->load->helper('security');

        if ($this->session->userdata('adminid_backend') == '') {
            if ($this->session->userdata('userid') == '') {
                redirect('backendportal');
            } else {

            } 
        }

    }

    /**
     * Load Workspace Page
     */
    public function index() {

        if($this->session->userdata("user_type") != 'Admin'){

            if($this->session->userdata("user_type_user")=='User'){  
                $userinfo = $this->common_model->get_common('zyra_user', '*', 'user_id', $this->session->userdata('userid'), '', '');

                $controlsForControllers=get_reseller_controls($userinfo->parent_id);  

                if(!array_key_exists(5,$controlsForControllers)){
                    return redirect("user/dashboard");
              }

          }
          else{
            $controlsForControllers=get_reseller_controls();  

            if(!array_key_exists(5,$controlsForControllers)){
              return redirect("backendportal");
          }
      }

  }

  if ($this->session->userdata('user_type_user') == 'User' && $this->uri->segment(1) == 'user') {
    $userinfo = $this->common_model->get_common('zyra_user', '*', 'user_id', $this->session->userdata('userid'), '', '');
    if($userinfo->feature=='freemium') { redirect('user/dashboard'); }
    $session_id = $this->session->userdata('userid');
    $data['session_type'] = 'User';
    $template_type = 'template_user';
} else {
    $session_id = $this->session->userdata('adminid_backend');
            //$data['workspacelist']  = $this->bot_builder_model->getWorkspaceCat($session_id, 'Y');
    $data['session_type'] = $this->session->userdata('user_type');;
    $template_type = 'template_admin';
}

$data['workspacelist'] = $this->bot_builder_model->getWorkspaceCat($session_id, 'Y', 'user');

$data['activeSidebar'] = 'workspace';
$data['created_user_id'] = $session_id;
$data['page_title'] = 'Workspace';
$data['main_content'] = 'botbuilder/workspace';
        //$data['workspacelist']  = $this->bot_builder_model->getWorkspaceCat($session_id, 'Y');
$data['catlist'] = $this->common_model->get_common_list('zyra_workspace_category', '*', 'status', 'Y', '', '');
$this->load->view("includes/$template_type", $data);
}

public function getWorkSpace() {

    $user_type = $this->input->post('user_type');

    if ($this->session->userdata('user_type_user') == 'User' && $user_type == 'User') {
        $session_id = $this->session->userdata('userid');

        $data['session_type'] = 'User';
        $template_type = 'template_user';
    } else {
        $session_id = $this->session->userdata('adminid_backend');
            //$data['workspacelist']  = $this->bot_builder_model->getWorkspaceCat($session_id, 'Y');
        $data['session_type'] = 'Admin';
        $template_type = 'template_admin';
    }

    $data['liveWorkspaceArr'] = array();
    if($data['session_type']!='User'){
       $getSelectedBot = $this->common_model->get_common('zyra_workspace_assign', 'workspace_id', 'user_id', $session_id, '', '');  
       $data['liveWorkspaceArr'] = explode(',',$getSelectedBot->workspace_id); 
   }

   $data['workspacelist'] = $this->bot_builder_model->getWorkspaceCat($session_id, 'Y', 'user');
   $data['default_workspace'] = $this->common_model->get_common('zyra_user', 'default_workspace_id,default_sms_workspace_id,default_fb_workspace_id', 'user_id', $session_id, '', '');
   $data['catlist'] = $this->common_model->get_common_list('zyra_workspace_category', '*', 'status', 'Y', '', '');
   $workspacelist = $this->load->view("botbuilder/workspacelist", $data, true);
   echo json_encode(['status' => true, 'html' => $workspacelist]);
}

    /**
     * Delete Workspace
     * @Ajaxcall
     */
    public function deleteWorkspace() {
        $auto_id = $this->input->post("auto_id");
        $data_array = array('status' => 'N');
        try {
            $this->common_model->update_data('zyra_workspace', $data_array, 'auto_id', $auto_id, null, null);
            echo json_encode(array("res" => 'success', 'msg' => 'Workspace has been deleted successfully.', 'id' => $auto_id));
        } catch (Exception $e) {
            echo json_encode(array("res" => 'error', 'msg' => $e->getMessage()));
        }
    }

    /**
     * Add Workspace
     * @Ajaxcall
     */
    public function addWorkspace() {
        $_POST = xss_clean($this->input->post());

        $name = $this->input->post("name");
        $catid = $this->input->post("catid");
        $session_id = decode_url_for_zyra($this->input->post("created_user_id"));
        $userinfo= $this->common_model->get_common('zyra_user', 'user_type', 'user_id', $session_id, '', '');
        $workspace_conv_type=$this->input->post("workspace_conv_type");
        $bot_type='';
        if(!empty($workspace_conv_type)){
         $bot_type= implode(',', json_decode($workspace_conv_type));
     }
     $usertype=$userinfo->user_type;


     $data_array = array('name' => $name, 'category_id' => $catid, 'user_id' => $session_id, 'status' => 'Y', 'created_date' => date('Y-m-d h:i:s'), 'updated_date' => date('Y-m-d h:i:s'),'bot_type'=>$bot_type);
     try {
        $auto_id = $this->common_model->store_data_insert_id('zyra_workspace', $data_array);

            // Add confused branch create default bracnh form each workspace
        $in=[1,5];
        $result = $this->bot_builder_model->get_common_list_withInQuery('zyra_workspace_dialog_default_branches', '*', 'id',$in);
        $pos=1;
        foreach($result as $res){
            $data_array = array('branch_name' => $res->name, 'workspace_id' => $auto_id, 'user_id' => $session_id, 'status' => 0, 'created_at' => date("Y-m-d H:i:s"), 'position' => $pos);
            $auto_id_branch = $this->common_model->store_data_insert_id('zyra_workspace_dialog_branches', $data_array);
            $queshpush = array(
                'question' => $res->text,
                'branch_id' => $auto_id_branch,
                'workspace_id' => $auto_id,
                'user_id' => $session_id,
                'status' => 0
            );
            $this->common_model->store_data('zyra_workspace_dialog_branch_questions', $queshpush);
            $pos++;
        }



        echo json_encode(array("res" => 'success', 'msg' => 'A new workspace has been added successfully.', 'id' => encode_url_for_zyra($auto_id),'user_type'=>$usertype));
    } catch (Exception $e) {
        echo json_encode(array("res" => 'error', 'msg' => $e->getMessage()));
    }
}

public function customBuilder() {


    if($this->session->userdata("user_type") != 'Admin'){

            if($this->session->userdata("user_type_user")=='User'){  
                $userinfo = $this->common_model->get_common('zyra_user', '*', 'user_id', $this->session->userdata('userid'), '', '');

                $controlsForControllers=get_reseller_controls($userinfo->parent_id);  

                if(!array_key_exists(5,$controlsForControllers)){
                    return redirect("user/dashboard");
              }

          }
          else{
            $controlsForControllers=get_reseller_controls();  

            if(!array_key_exists(5,$controlsForControllers)){
              return redirect("backendportal");
          }
      }

  }


  $workspace_id = decode_url_for_zyra($this->uri->segment(3));

  if ($this->session->userdata('user_type_user') == 'User' && $this->uri->segment(1) == 'user') {
    $session_id = $this->session->userdata('userid');
    $template = 'template_user';
    $data['type'] = "User";
    $data['data_show'] = false;
} else {
    $session_id = $this->session->userdata('adminid_backend');
    $template = 'template_admin';
    $data['type'] = "Admin";
    if($this->session->userdata('user_type')=='Admin'){
     $data['data_show'] = true; 
 }else{
     $data['data_show'] = false; 
 }

}

        //$table, $selectfield, $tablefield, $id, $tablefield2, $id2, $user_type = null

$data['default_workspace'] = $this->common_model->get_common('zyra_user', 'default_workspace_id,default_sms_workspace_id,default_fb_workspace_id', 'user_id', $session_id, '', '');


$data['activeSidebar'] = 'workspace';
$data['page_title'] = 'Workspace';
try {
    $data['workspace_detail'] = $this->bot_builder_model->getWorkSpaceDetails($workspace_id);
    $data['latest_update_branch_time'] = $this->bot_builder_model->getLatestUpdateBranchTime($workspace_id);
    $data['default_branches'] = $this->bot_builder_model->getDefaultBranches();
    $data['main_content'] = 'botbuilder/customBuilder';
    $data['branchLists'] = $this->bot_builder_model->getBranchLists($workspace_id, $session_id);
    $data['workspace_id'] = $workspace_id;
    $data['user_id'] = $session_id;

            //check if the workspace brach saveed permanently or not

    $load_chatbot = false;

    if (!empty($data['branchLists']) && count($data['branchLists']) > 0) {
        $stauschatbot = $data['branchLists'][0]->status;
        if ($stauschatbot == 1) {
            $load_chatbot = true;
        }
    }


    $data['load_chatbot'] = $load_chatbot;

    $this->bot_builder_model->getWorkSpaceDetails($workspace_id);
} catch (Exception $e) {

}
$this->load->view("includes/$template", $data);
}

    /**
     * Load Custom Builder Page from ajax
     *
     * @Ajaxcall 
     * 
     */
    public function loadCustomBuilder() {
        $workspace_id = decode_url_for_zyra($this->input->post("workspace_id"));
        $user_id = decode_url_for_zyra($this->input->post("user_id"));
        $userinfo = $this->common_model->get_common('zyra_user','*','user_id',$user_id,'',''); 
        try {
            $data['default_branches'] = $this->bot_builder_model->getDefaultBranches();
            $data['bot_type'] = $this->common_model->get_common('zyra_workspace','bot_type','auto_id',$workspace_id,'','');
            $data['workspace_id'] = $workspace_id;
            $data['userinfo'] = $userinfo;
            $data['captured_as'] = $this->bot_builder_model->getCapturedFields($workspace_id);
            $data['total_branch_count'] = $this->bot_builder_model->getBranchListsCount($workspace_id);
            $data['countryCodeLists'] = $this->common_model->get_common_list('zyra_country_code_lists', '*', 'is_default', '0', '', '');
            $data['defaultCountryCodeLists'] = $this->common_model->get_common_list('zyra_country_code_lists', '*', 'is_default', '1', '', '');

            
            /* Changed review with multiple location */


            $totalReviewlink = $this->bot_builder_model->get_multiple_review_location($user_id);
            $data['totalReviewlink']=$totalReviewlink;
            $data['location_list'] =  $this->common_model->get_common_list_bysort('zyra_user_location_review', '*', 'user_id', $user_id, 'chat_bot_id', $userinfo->chatBot_id , 'ASC', 'location');
            $branchDetail = $this->load->view("botbuilder/branchDetail", $data, true);
            
            echo json_encode(['msg' => true, 'html' => $branchDetail]);
        } catch (Exception $e) {
            echo json_encode(['msg' => false, 'html' => '']);
        }
    }

    /**
     * Rename Workspace
     * @Ajaxcall
     */
    public function renameWorkspace() {
        $name = $this->input->post("name");
        $rid = $this->input->post("rid");
        $update_array = array('name' => $name);
        try {
            $auto_id = $this->common_model->update_data_multiple_condition('zyra_workspace', array('auto_id' => $rid), $update_array);
            echo json_encode(array("res" => 'success', 'msg' => 'Workspace renamed successfully.'));
        } catch (Exception $e) {
            echo json_encode(array("res" => 'error', 'msg' => $e->getMessage()));
        }
    }

    /**
     * Save Branches to workspace
     *
     * @Ajaxcall 
     * 
     */
    public function saveBranch() {


        //$_POST = xss_clean($this->input->post());

        $workspaceid = decode_url_for_zyra($this->input->post('workspace_id'));
        $branchname = $this->input->post('buttonTitle');
        $questions = array();
        //parse_str($_POST['textarea'], $questions);
        foreach($_POST['textarea'] as $ques){
         $questions[]= $ques;
     }


     $buttons = $this->input->post('button');
     $validation      = $this->input->post('validation');
     $validationReply = $this->input->post('validationReply');

     $replyCap = $this->input->post('replyCap');
     $user_id = decode_url_for_zyra($this->input->post('created_user_id'));
     $action = $this->input->post('action');
     $branchAI = $this->input->post('branchlistAI');
     $target_branch_type = $this->input->post('target_branch_type');
     if($this->input->post('is_end')=='true'){
        $is_end = 'Y';
    }else{
        $is_end = '';
    }

    $is_team_profile = 0;
    $team_workspace_members = 0;
    if (isset($_POST['is_team_profile'])) {
        if ($this->input->post('is_team_profile') == 'true') {
            $is_team_profile = 1;
        }
    }

    if (isset($_POST['team_workspace_members'])) {
        if ($this->input->post('team_workspace_members') == 'true') {
            $team_workspace_members = 1;
        }
    }

    $aiRules = array();
    parse_str($_POST['aiBranchRules'], $aiRules);

    $questionResponses= array();
    parse_str($_POST['questionResponses'], $questionResponses);

    $teamData = array();
    if (isset($_POST['team_data'])) {
        parse_str($_POST['team_data'], $teamData);
    }


    $branch_id = "";
    $update = false;
    if ($action == 'update') {
        $update = true;
        $branch_id = $this->input->post('branch_id');
    }

    $branchItem = '';
    try {
        $conditions = array();
            if ($update) {      // update in branch table
                $conditions = array('branch_id' => $branch_id, 'workspace_id' => $workspaceid, 'user_id' => $user_id);
                if ($branchAI != '') {
                    $updatearray = array('branch_name' => $branchname, 'workspace_id' => $workspaceid, 'user_id' => $user_id, 'validation' => $validation,'validation_reply'=> json_encode($validationReply),  'updated_at' => date("Y-m-d H:i:s"), 'capture_as' => $replyCap, 'target_branch' => $branchAI, 'is_end' =>$is_end,'team_profile'=>$is_team_profile,'team_workspace_members'=>$team_workspace_members,'target_branch_type'=>$target_branch_type,'show_country_code'=>$this->input->post('show_country_code'));
                } else {
                    $updatearray = array('branch_name' => $branchname, 'workspace_id' => $workspaceid, 'user_id' => $user_id, 'validation' => $validation,'validation_reply'=> json_encode($validationReply),  'updated_at' => date("Y-m-d H:i:s"), 'capture_as' => $replyCap, 'is_end' =>$is_end,'team_profile'=>$is_team_profile,'team_workspace_members'=>$team_workspace_members,'show_country_code'=>$this->input->post('show_country_code'));
                }
                /* New Code for transction rule */
                $updatearray['transscript_rule']='';
                $updatearray['trans_script_rule_button']='';
                if($is_end=='Y'){
                    if(!empty($_POST['transscript_rule'])){
                        $updatearray['transscript_rule']=$_POST['transscript_rule'];
                        $updatearray['trans_script_rule_button']=$_POST['trans_script_rule_button'];
                    }
                }

                /* End New Code for transction rule */
                $this->common_model->update_data_multiple_condition('zyra_workspace_dialog_branches', $conditions, $updatearray);
                $auto_id = $branch_id;
                $success_message = 'Branch updated successfully'; 
                
            } else {     // store in branch table
                $position = $this->bot_builder_model->getLastBranchPosition($workspaceid);
                $data_array = array('branch_name' => $branchname, 'workspace_id' => $workspaceid, 'user_id' => $user_id, 'validation' => $validation,'validation_reply'=> json_encode($validationReply), 'status' => 0, 'created_at' => date("Y-m-d H:i:s"), 'position' => $position + 1, 'capture_as' => $replyCap, 'target_branch' => $branchAI, 'is_end' =>$is_end,'team_profile'=>$is_team_profile,'team_workspace_members'=>$team_workspace_members,'target_branch_type'=>$target_branch_type);
                $auto_id = $this->common_model->store_data_insert_id('zyra_workspace_dialog_branches', $data_array);
                $success_message = 'Branch added successfully';
            }
            
            $team_members_del_array = ['branch_id' => $auto_id, 'user_id' => $user_id, 'workspace_id' => $workspaceid];
            $this->common_model->delete_data_by_multiple_condition('zyra_workspace_team_members', $team_members_del_array);

            if (!empty($teamData['team_data'])) {
                $insert_team_array = array();
                foreach ($teamData['team_data'] as $team) {
                    $data = [
                        'user_id' => $user_id,
                        'workspace_id' => $workspaceid,
                        'branch_id' => $auto_id,
                        'email' => $team['email'],
                        'phone' => $team['phone'],
                        'created_at' => date("Y-m-d H:i:s"),
                    ];
                    array_push($insert_team_array, $data);
                }
                $this->common_model->insertBatch('zyra_workspace_team_members', $insert_team_array);
            }



            // store in questions table  
            if ($auto_id) {
                if ($update) {
                    // delete question  data from question table insert
                    $conditions = array('branch_id' => $branch_id, 'workspace_id' => $workspaceid, 'user_id' => $user_id);
                    $this->common_model->delete_data_by_multiple_condition('zyra_workspace_dialog_branch_questions', $conditions);

                    // delete   data from button table insert
                    $this->common_model->delete_data_by_multiple_condition('zyra_workspace_dialog_branch_buttons', $conditions);
                    $this->common_model->delete_data_by_multiple_condition('zyra_workspace_dialog_branches_ai_rules', $conditions);
                    $this->common_model->delete_data_by_multiple_condition('zyra_workspace_question_reponse', $conditions);
                }
                if (!empty($questions)) {
                    $insertquestions = array();
                    foreach ($questions as $question) {
                        $queshpush = array(
                            'question' => $question,
                            'branch_id' => $auto_id,
                            'workspace_id' => $workspaceid,
                            'user_id' => $user_id,
                            'status' => 0
                        );
                        array_push($insertquestions, $queshpush);
                    }

                    $this->common_model->insertBatch('zyra_workspace_dialog_branch_questions', $insertquestions);
                }

                // store in button table
                $branch_hasbutton=false;
                if (!empty($buttons)) {
                    $insertbuttons = array();
                    foreach ($buttons as $button) {
                        $respondonbranch = '';
                        $respondonurl = '';
                        $respondonphone = '';
                        $respondsms = '';
                        $respondreview = '';
                        $type = '';
                        $button_review_location="";
                        if ($button['type'] == 'Branch') {
                            $branch_hasbutton=true;
                            $respondonbranch = $button['value'];
                        }
                        if ($button['type'] == 'URL') {

                            $respondonurl = $button['value'];
                        }
                        $countryCode = "+91";
                        if ($button['type'] == 'PhoneCall') {


                            $to_phone = str_replace('(', '', trim($button['value']));
                            $to_phone = str_replace(')', '', $to_phone);
                            $to_phone = str_replace(' ', '', $to_phone);
                            $to_phone = str_replace('-', '', $to_phone);
                            $to_phone = str_replace('+', '', $to_phone);
                            $to_phone = substr($to_phone, -10);

                            $respondonphone = $to_phone;
                            if (isset($button['countryCode']) && $button['countryCode'] !='' ){
                                $countryCode = $button['countryCode'];
                            }
                        }
                        
                        
                        if ($button['type'] == 'SMS') {


                            $to_phone = str_replace('(', '', trim($button['value']));
                            $to_phone = str_replace(')', '', $to_phone);
                            $to_phone = str_replace(' ', '', $to_phone);
                            $to_phone = str_replace('-', '', $to_phone);
                            $to_phone = str_replace('+', '', $to_phone);
                            $to_phone = substr($to_phone, -10);

                            $respondsms = $to_phone;
                            if (isset($button['countryCode']) && $button['countryCode'] !='' ){
                                $countryCode = $button['countryCode'];
                            }
                            
                        }
                        
                        if ($button['type'] == 'REVIEW') {
                            $review_data=explode('$$',$button['value']);

                            $respondreview=$review_data[0];
                            $button_review_location=isset($review_data[1]) ?  $review_data[1]: '';

                        }
                        

                        $pusharray = array(
                            'button_title' => $button['title'],
                            'button_respond_on' => $button['type'],
                            'button_respond_on_branch' => $respondonbranch,
                            'button_respond_on_url' => $respondonurl,
                            'button_respond_on_phonecall' => $respondonphone,
                            'button_respond_on_sms' => $respondsms,
                            'button_respond_on_phonecall_country_code' => $countryCode,
                            'branch_id' => $auto_id,
                            'workspace_id' => $workspaceid,
                            'user_id' => $user_id,
                            'status' => 0,
                            'button_phone_call_use_phone_var'=>$button['button_phone_call_use_phone_var'],
                            'button_phone_call_use_dynamic_call'=>$button['button_phone_call_use_dynamic_call'],
                            'button_phone_call_use_input_method'=>$button['button_phone_call_use_input_method'],
                            'button_respond_on_review'=>$respondreview,
                            'button_review_location'=>$button_review_location
                        );
                        array_push($insertbuttons, $pusharray);
                    }
                    $this->common_model->insertBatch('zyra_workspace_dialog_branch_buttons', $insertbuttons);

                    // update workspace updated date   
                    $this->updateWorkspaceModifiedTime($workspaceid);
                }

                if($branch_hasbutton){
                  $conditions2 = array('branch_id' => $branch_id, 'workspace_id' => $workspaceid, 'user_id' => $user_id);
                  $this->common_model->update_data_multiple_condition('zyra_workspace_dialog_branches', $conditions2, ['attachment_on_off'=>0]);  
              }

                // save Ai rules for a branch

              if (!empty($aiRules)) {
                $aiRulesinsert = array();
                foreach ($aiRules['AIRules'] as $ai) {
                    $aipush = array(
                        'intent_id' => $ai['intent_id'],
                        'intent_branch_id' => $ai['branch_id'],
                        'branch_id' => $auto_id,
                        'workspace_id' => $workspaceid,
                        'user_id' => $user_id,
                        'status' => 0,
                        'cat_id'=> $ai['cat_id'],
                        'sub_cat_id'=> $ai['sub_cat_id'],
                    );
                    array_push($aiRulesinsert, $aipush);
                }

                $this->common_model->insertBatch('zyra_workspace_dialog_branches_ai_rules', $aiRulesinsert);
            }
                // End save Ai rules for a branch

            if(!empty($questionResponses)){
                $insertQuestionResponse = array();
                foreach ($questionResponses['questionResponse'] as $question) {
                    $queshpushres = array(
                        'question' => $question,
                        'branch_id' => $auto_id,
                        'workspace_id' => $workspaceid,
                        'user_id' => $user_id,
                        'status' => 1,
                        'created_at'=>date("Y-m-d H:i:s")
                    );
                    array_push($insertQuestionResponse, $queshpushres);
                }

                $this->common_model->insertBatch('zyra_workspace_question_reponse', $insertQuestionResponse);
            }

                // Add Custom response to A question if exist


            $loaddata['branchLists'] = $this->bot_builder_model->getSingleBranchInfo($auto_id, $user_id);
            $branchItem = $this->load->view("botbuilder/load_branches", $loaddata, true);



                // update updated time in workspace
        }
        echo json_encode(array("res" => 'success', 'msg' => $success_message, 'id' => $auto_id, 'html' => $branchItem));
    } catch (Exception $e) {
        echo json_encode(array("res" => 'error', 'msg' => $e->getMessage()));
    }
}

    /**
     * Get Branch data
     *
     * @Ajaxcall 
     * @ rerun brach details
     */
    function editBranch() {
        $workspace_id = decode_url_for_zyra($this->input->post('workspace_id'));
        $branch_id = $this->input->post('id');
        $user_id = decode_url_for_zyra($this->input->post('user_id'));
        $userinfo = $this->common_model->get_common('zyra_user','*','user_id',$user_id,'',''); 
        try {
            $branch_details = $this->bot_builder_model->getBranchdetails($branch_id, $workspace_id, $user_id);
            $branch_questions = "";
            $branch_buttons = "";
            $branch_ai_html = "";
            if (!empty($branch_details)) {
                $bracnhtitle = $branch_details['branch_name'];
                $validation = $branch_details['validation'];

                $data['bot_type'] = $this->common_model->get_common('zyra_workspace','bot_type','auto_id',$workspace_id,'','');
                // get branch questions 
                $branch_questions = $this->bot_builder_model->getBranchQuestions($branch_id, $workspace_id, $user_id);
                $data['branch_questions']=$branch_questions;
                // get branch questions
                $branch_buttons = $this->bot_builder_model->getBranchButtons($branch_id, $workspace_id, $user_id);
                $data['branch_buttons']=$branch_buttons;
                $branchList = $this->bot_builder_model->getBranchLists($workspace_id, $user_id);
                $data['branchDropdown']=$branchList;
                $data['branchList']=$branchList;
                $data['userinfo']=$userinfo;
                if ( isset($branch_details['validation_reply']) ){
                    $branch_details['validation_reply'] = json_decode($branch_details['validation_reply']); 
                }
                $data['branch_details']=$branch_details;
                $data['ai_list'] = $this->bot_builder_model->branchAIRules($branch_id);
                
                //$branch_ai_html = $this->load->view("botbuilder/branchAIRules", $meta, true);
                
                $data['team_data'] = $this->bot_builder_model->branchTeamMember($branch_id);
                $data['additions_captured'] = $this->common_model->get_common_list('zyra_workspace_additional_captured','*','workspace_id',$workspace_id,'status','1');

                $data_multi['multiple_choice_options'] = $this->bot_builder_model->multiple_choice_options($branch_id);
                $data_multi['branch_id']=$branch_id;
                
                $html_multiple_choice = $this->load->view("botbuilder/multiple_choice_option", $data_multi, true);
                
                $meta_rule['is_end']=$branch_details['is_end'];
                $meta_rule['trans_script_rule_button']=$branch_details['trans_script_rule_button'];
                $meta_rule['transscript_rule']=$branch_details['transscript_rule'];
                $transcript_rule = $this->load->view("botbuilder/transscript_rule", $meta_rule, true);
                
                $data['checkzipcaptured']=false;

                if($branch_details['validation']=='zipcode' && $branch_details['capture_as']=='zipcode'){
                  $this->db->select('*');
                  $this->db->from('zyra_workspace_branch_zipcode_rules');
                  $this->db->where('branch_id',$branch_id);
                  $result_zipcode=$this->db->get()->result();
                  if(!empty($result_zipcode)){
                      $data['checkzipcaptured']=true;  
                  }
              }

              $totalReviewlink = $this->bot_builder_model->get_multiple_review_location($user_id);
              $data['totalReviewlink']=$totalReviewlink;
              $data['question_response_list'] = $this->common_model->get_common_list('zyra_workspace_question_reponse','*','branch_id',$branch_id,'','');
              $data['workspace_branch_url'] = $this->common_model->get_common_list('zyra_workspace_branch_url','*','branch_id',$branch_id,'','');

              $html = $this->load->view("botbuilder/editBranch", $data, true);
          }
          echo json_encode(array("res" => 'success', 'msg' => 'Branch added successfully.', 'details' => $branch_details, 'html'=>$html,'html_multiple_choice'=>$html_multiple_choice,'transcript_rule'=>$transcript_rule,'checkzipcaptured'=>$data['checkzipcaptured'],'totalReviewlink'=>$totalReviewlink));
      } catch (Exception $e) {
        echo json_encode(array("res" => 'success', 'msg' => $e->getMessage(), 'id' => $auto_id));
    }
}





function getBranchLists() {
    if (!$this->input->is_ajax_request()) {
        exit("Direct access not allowed");
    }
    $workspace_id = decode_url_for_zyra($this->input->post("workspace_id", true));
    $session_id = decode_url_for_zyra($this->input->post("created_user_id", true));


    $data['branchLists'] = $this->bot_builder_model->getBranchLists($workspace_id, $session_id);
    $totalReviewlink = $this->bot_builder_model->get_multiple_review_location($session_id);

    $data['totalReviewlink']=$totalReviewlink;
    $branchLists = $this->load->view("botbuilder/load_branches", $data, true);
    echo json_encode(['msg' => true, 'html' => $branchLists,'totalReviewlink'=>$totalReviewlink]);
}

function deleteBranch() {
    if (!$this->input->is_ajax_request()) {
        exit("Direct access not allowed");
    }
    $branch_id = $this->input->post("branch_id", true);
    $workspaceid = decode_url_for_zyra($this->input->post("workspace_id", true));
    $branchdata = $this->common_model->get_common('zyra_workspace_dialog_branches', 'position', 'branch_id', $branch_id, '', '');
    $position = $branchdata->position;
    $conditions = array('workspace_id' => $workspaceid, 'button_respond_on_branch' => $branch_id);
    $get_target_brach = $this->common_model->get_list_by_multiple_condition('zyra_workspace_dialog_branch_buttons', $conditions);
    if (!empty($get_target_brach)) {
        foreach ($get_target_brach as $getbrach) {
            $update_array = array('button_respond_on_branch' => 0);
            $cnd_tion = array('auto_id' => $getbrach->auto_id);
            $this->common_model->update_data_multiple_condition('zyra_workspace_dialog_branch_buttons', $cnd_tion, $update_array);
        }
    }
    if ($branch_id && (int) $branch_id > 0) {

        $resp = $this->bot_builder_model->deleteBranchAndAssociatedRecord($branch_id, $position);
        if ($position) {
            $update = $this->bot_builder_model->updateBranchPosition($position, $workspaceid);
        }
        $this->updateWorkspaceModifiedTime($workspaceid);
        echo json_encode($resp);
    } else {
        echo json_encode(['msg' => false, 'message' => 'Invalid branch']);
    }
}

function createDefaultBranch() {
    if (!$this->input->is_ajax_request()) {
        exit("Direct access not allowed");
    }
    $response = array();

    $title = $this->input->post('title');
    $question = $this->input->post('question');
    $workspace_id = decode_url_for_zyra($this->input->post('workspace_id'));
    $user_id = decode_url_for_zyra($this->input->post("user_id", true));


    if ($title != '' && $question != '') {
        $position = $this->bot_builder_model->getLastBranchPosition($workspace_id);
        $data_array = array('branch_name' => $title, 'workspace_id' => $workspace_id, 'user_id' => $user_id, 'status' => 0, 'created_at' => date("Y-m-d H:i:s"), 'position' => $position + 1);
        $auto_id = $this->common_model->store_data_insert_id('zyra_workspace_dialog_branches', $data_array);
        if ($auto_id) {
            $insertquestions = array(
                'question' => $question,
                'branch_id' => $auto_id,
                'workspace_id' => $workspace_id,
                'user_id' => $user_id,
                'status' => 0
            );
            $inserted_id = $this->common_model->store_data_insert_id('zyra_workspace_dialog_branch_questions', $insertquestions);
            if ($inserted_id) {
                $this->updateWorkspaceModifiedTime($workspace_id);
                $data['branchLists'] = $this->bot_builder_model->getSingleBranchInfo($auto_id, $user_id);
                $branchLists = $this->load->view("botbuilder/load_branches", $data, true);
                $response = ['msg' => true, 'html' => $branchLists];
            } else {
                $response = ['msg' => false];
            }
        } else {
            $response = ['msg' => false];
        }
    } else {
        $response = ['msg' => false];
    }
    echo json_encode($response);
}

public function updateWorkspaceModifiedTime($workspaceid) {
    $conditions_w = array('auto_id' => $workspaceid);
    $updatearray_w = array('updated_date' => date("Y-m-d H:i:s"));
    $this->common_model->update_data_multiple_condition('zyra_workspace', $conditions_w, $updatearray_w);
}

    /**
     * Setup AI Rules
     * @Ajaxcall
     */
    function setupRules() {
        //$session_id = $this->session->userdata('adminid_backend');
        if ($this->session->userdata('user_type_user') == 'User' && $this->uri->segment(1) == 'user') {
            $session_id = $this->session->userdata('userid');
        } else {
            $session_id = $this->session->userdata('adminid_backend');
        }
        $workspace_id = decode_url_for_zyra($this->input->post('workspace_id'));
        $data['activeSidebar'] = 'setupairules';
        $data['page_title'] = 'Setup AI Rules';
        try {
            $data['rulesListing'] = $this->common_model->get_common_list('zyra_workspace_ai_rules', '*', 'workspace_id', $workspace_id, '', '');
            $branchList = $this->common_model->get_common_list('zyra_workspace_dialog_branches', '*', 'workspace_id', $workspace_id, '', '');
            unset($branchList[0]);
            unset($branchList[1]);
            $data['branchList'] = $branchList;
            $setupRules = $this->load->view('botbuilder/setupRules', $data, true);
            echo json_encode(['msg' => true, 'html' => $setupRules]);
        } catch (Exception $e) {
            echo json_encode(['msg' => false, 'html' => '']);
        }
    }

    /**
     * Branches List Dropdown
     * @Ajaxcall
     */
    function BranchesList() {

        //$user_id = $this->session->userdata('adminid_backend');
        $workspace_id = decode_url_for_zyra($this->input->post('workspace_id'));
        $user_id = decode_url_for_zyra($this->input->post('user_id'));
        $element = $this->input->post('element');
        $branch_id = $this->input->post('branch_id');
        $data['branchDropdown'] = $this->bot_builder_model->getBranchLists($workspace_id, $user_id);
        $data['branch_id'] = $branch_id;
        $data['element'] = $element;
        try {
            $branchLists = $this->load->view('botbuilder/branchDropdown', $data, true);
            echo json_encode(['msg' => true, 'html' => $branchLists]);
        } catch (Exception $e) {
            echo json_encode(['msg' => false, 'html' => '']);
        }
    }

    /**
     * Save AI Rules for workspace
     * @Ajaxcall
     */
    function saveAIRules() {
        if (!$this->input->is_ajax_request()) {
            exit("Direct access not allowed");
        }
        parse_str($_POST['formData'], $data);
        $workspace_id = decode_url_for_zyra($this->input->post('workspace_id'));
        try {

            $insert_array = [];
            if (!empty($data['airules'])) {
                $conditions = array('workspace_id' => $workspace_id);
                $this->common_model->delete_data_by_multiple_condition('zyra_workspace_ai_rules', $conditions);

                foreach ($data['airules'] as $airules) {
                    $array = [
                        'keywords' => $airules['tags'],
                        'workspace_id' => $workspace_id,
                        'branch_id' => $airules['branch'],
                    ];
                    array_push($insert_array, $array);
                }

                $this->common_model->insertBatch('zyra_workspace_ai_rules', $insert_array);
            }
            echo json_encode(['status' => true, 'message' => 'Successfully added']);
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'message' => 'Error Occured']);
        }
    }

    /**
     * Save AI Rules for workspace
     * @Ajaxcall
     */
    function saveWorkSpaceFlow() {
        if (!$this->input->is_ajax_request()) {
            exit("Direct access not allowed");
        }

        $workspace_id = decode_url_for_zyra($this->input->post('workspace_id'));
        $user_id = decode_url_for_zyra($this->input->post('user_id'));
        //$user_id = $this->session->userdata('adminid_backend');

        try {
            //zyra_workspace_dialog_branches
            $update_array = array('status' => 1);
            $condition = array('workspace_id' => $workspace_id, 'user_id' => $user_id);
            $this->common_model->update_data_multiple_condition('zyra_workspace_dialog_branches', $condition, $update_array);
            $this->common_model->update_data_multiple_condition('zyra_workspace_dialog_branch_buttons', $condition, $update_array);
            $this->common_model->update_data_multiple_condition('zyra_workspace_dialog_branch_questions', $condition, $update_array);
            $this->common_model->update_data_multiple_condition('zyra_workspace_dialog_branches_ai_rules', $condition, $update_array);
            //zyra_workspace_dialog_branch_buttons
            //zyra_workspace_dialog_branch_questions
            
            $latest_update_time=$this->bot_builder_model->getLatestUpdateBranchTime($workspace_id);
            if(!empty($latest_update_time)){
               $preview_update_date = $latest_update_time->updated_at;

               $update_preview_array = array('preview_date' => $preview_update_date);
               $conditions = array('auto_id' => $workspace_id, 'user_id' => $user_id);
               $this->common_model->update_data_multiple_condition('zyra_workspace', $conditions, $update_preview_array);

           }


           $update_arr = array('response_time' => $this->input->post('response_time'));
           $conditions = array('auto_id' => $workspace_id, 'user_id' => $user_id);
           $this->common_model->update_data_multiple_condition('zyra_workspace', $conditions, $update_arr);

            // get latest update branch time


            // update 
           echo json_encode(['status' => true, 'message' => 'Successfully added']);
       } catch (Exception $e) {
        echo json_encode(['status' => false, 'message' => 'Error Occured']);
    }
}

    /**
     * Get User Workspace Id if exist otherwise return Admin Workspace ID
     * @Ajaxcall
     */
    function jumpToUserWorkspace() {
        try {
            $workspace_id = decode_url_for_zyra($this->input->post('workspace_id'));
            $user_id = $this->session->userdata('userid');
            $result = $this->common_model->get_common('zyra_workspace', '*', 'auto_id', $workspace_id, 'user_id', $user_id);

            if (!empty($result)) {
                $rworkspace_id = $this->input->post('workspace_id');
                echo json_encode(['status' => true, 'workspace_id' => $rworkspace_id]);
            } else {
                $w_details = $this->bot_builder_model->create_workspace_user($workspace_id, $user_id);
                if (!empty($w_details)) {
                    echo json_encode(['status' => true, 'workspace_id' => encode_url_for_zyra($w_details)]);
                } else {
                    echo json_encode(['status' => false, 'message' => 'error']);
                }
            }
        } catch (Exception $e) {
            echo json_encode(['status' => true, 'message' => 'Error Occured']);
        }
    }

    function assignWorkSpace() {
        try {
            //$user_id = $this->session->userdata('userid');
            $user_id= decode_url_for_zyra($this->input->post('created_user_id'));
            $result = $this->common_model->get_common('zyra_user', '*', 'user_id', $user_id, '', '');
              //----------------- Filter workspace acc admin live workspace ---------------------------
            if($result->user_type=='User'){
                if($result->parent_id==0){
                   $workspace_user_id = ADMINID;
               }else{
                   $workspace_user_id = $result->parent_id;
               }

               $getSelectedBot = $this->common_model->get_common('zyra_workspace_assign', 'workspace_id', 'user_id', $workspace_user_id, '', '');
               $wp_d=$getSelectedBot->workspace_id;

           }else{
              $wp_d="";
          }

            //---------------------------------------------------------------------------------------
          $assign = $this->bot_builder_model->assignWorkspaceToUser($user_id,$result->parent_id,$wp_d,$result);
          echo json_encode(['status' => true, 'workspace_id' => encode_url_for_zyra($assign)]);
      } catch (Exception $e) {
        echo json_encode(['status' => true, 'message' => 'Error Occured']);
    }
}

function assignDefaultWorkSpaceID() {
    try {
        $user_id = $this->session->userdata('userid');
        $workspace_id = decode_url_for_zyra($this->input->post('workspace_id'));
        $bot_type = $this->input->post('bot_type');
        $status = $this->input->post('status');


        $default_workspace_detail=$this->common_model->get_common('zyra_user', 'default_workspace_id,default_sms_workspace_id,default_fb_workspace_id', 'user_id', $user_id, '', '');
        if ($status == 0) {
            $default_workspace_id = 0;
        } else {
            $default_workspace_id = "CB_".$workspace_id;
        }
        $array=[];

        if ($bot_type == 'WEB') {
            $array['default_workspace_id'] = $default_workspace_id;

        }

        if($bot_type=='SMS'){
         $array['default_sms_workspace_id'] = $default_workspace_id;

     }

     if($bot_type=='FB'){
         $array['default_fb_workspace_id'] = $default_workspace_id;

     }

     if($bot_type=='FBSMS'){
        $array['default_sms_workspace_id'] = $default_workspace_id;
        $array['default_fb_workspace_id'] = $default_workspace_id;
    }


    $this->db->where('user_id', $user_id);
    $this->db->update('zyra_user', $array);

    echo json_encode(['status' => true]);
} catch (Exception $e) {
    echo json_encode(['status' => true, 'message' => 'Error Occured']);
}
}

function updatePosition() {
    try {

        $workspace_id = decode_url_for_zyra($this->input->post('workspace_id'));
        $positions = $this->input->post('positions');
        foreach ($positions as $position) {
            $condition = array('branch_id' => $position['branch_id']);
            $array_to_update = array('position' => $position['position']);
            $this->common_model->update_data_multiple_condition('zyra_workspace_dialog_branches', $condition, $array_to_update);
        }


        echo json_encode(['status' => true]);
    } catch (Exception $e) {
        echo json_encode(['status' => true, 'message' => 'Error Occured']);
    }
}

function loadButtonContent() {
    $data['buttonType'] = $this->input->post('type');
    if ($data['buttonType'] == 'Button') {

    }
    if ($data['buttonType'] == 'AI') {

    }
    if ($data['buttonType'] == 'Webhook') {

    }

    $branchLists = $this->load->view('botbuilder/branchButtonContent', $data, true);
    echo json_encode(['res' => 'success', 'html' => $branchLists]);
}


public function intentEngine() {

   if($this->session->userdata("user_type") != 'Admin'){

            if($this->session->userdata("user_type_user")=='User'){  
                $userinfo = $this->common_model->get_common('zyra_user', '*', 'user_id', $this->session->userdata('userid'), '', '');

                $controlsForControllers=get_reseller_controls($userinfo->parent_id);  

                if(!array_key_exists(5,$controlsForControllers)){
                    return redirect("user/dashboard");
              }

          }
          else{
            $controlsForControllers=get_reseller_controls();  

            if(!array_key_exists(5,$controlsForControllers)){
              return redirect("backendportal");
          }
      }

  }


  $data['activeSidebar'] = 'intentengine';
  $data['page_title'] = 'Intent Engine';

  if($this->session->userdata("user_type") == 'Admin'){
    $data['main_content'] = 'intentengine/index';
    $data['data_show'] = true;
}else{

    $data['main_content'] = 'intentengine/userintentEngine'; 
    $data['data_show'] = false;
}
$data['created_user_id']=$this->session->userdata('adminid_backend');
$template_type = 'template_admin';
$data['subcategory'] = $this->common_model->get_common_list_bysort('zyra_intent_sub_category', '*', 'id>', '0', '', '','asc','name');
$this->load->view("includes/$template_type", $data);
}

public function getCategoryList() {
    try {

        $data['lists'] = $this->common_model->get_common_list_bysortwithcount('zyra_intent_category', '*', 'id>', '0', '', '','asc','name','zyra_intent_sub_category','cat_id');
            //$data['count_show']= $this->input->post('data_show_cat_wise');
        $data['count_show']= true;
        $data['title'] = "Main Categories";
        $data['type'] = "cat";
        $data['selected_intent_id'] = $this->input->post('selected_cat_id');
        $categoryLists = $this->load->view('intentengine/dropdown', $data, true);
        echo json_encode(['status' => true, 'html' => $categoryLists]);
    } catch (Exception $e) {
        echo json_encode(['status' => false, 'html' => '']);
    }
}

public function getSubCategoryList() {
    try {



        $cat_id = $this->input->post('cat_id');
        $data['title'] = "Sub Categories";
        $data['type'] = "sub-cat";
            //$data['count_show']= $this->input->post('data_show_cat_wise');
        $data['count_show']= true;
        $data['selected_intent_id'] = $this->input->post('selected_sub_cat_id');
        if (empty($cat_id)) {
            $data['lists'] = $this->common_model->get_common_list_bysortwithcount('zyra_intent_sub_category', '*', 'id>', '0', '', '','asc','name','zyra_intent','sub_cat_id');
        } else {
            $data['lists'] = $this->common_model->get_common_list_bysortwithcount('zyra_intent_sub_category', '*', 'cat_id', $cat_id, '', '','asc','name','zyra_intent','sub_cat_id');
        }
        $categoryLists = $this->load->view('intentengine/dropdown', $data, true);
        echo json_encode(['status' => true, 'html' => $categoryLists]);
    } catch (Exception $e) {
        echo json_encode(['status' => false, 'html' => '']);
    }
}

public function getIntentList() {
    try {

        $cat_id = $this->input->post('cat_id');
        $sub_cat_id = $this->input->post('sub_cat_id');
        $created_user_id = decode_url_for_zyra($this->input->post('created_user_id'));

        $user_type_arr=$this->common_model->get_common('zyra_user','user_type','user_id',$created_user_id,'','');
        $user_type=$user_type_arr->user_type;
        $order_by='name';
        $order="asc";
        if(isset($_POST['orderby']) && !empty($_POST['orderby'])){
            $order_by='count';
            if(isset($_POST['order']) && !empty($_POST['order'])){
                $order=$_POST['order'];
            }else{
                $order='desc';
            }
        }

        $data['title'] = "Intents";
        $data['type'] = "intent";
        $data['count_show']= $this->input->post('data_show_cat_wise');
        $data['selected_intent_id'] = $this->input->post('selected_intent_id');
        if (empty($cat_id)  && empty($sub_cat_id)) {
            $data['lists'] = $this->common_model->get_common_list_bysortwithcount('zyra_intent', '*', 'id>', '0', '', '',$order,$order_by,'zyra_intent_examples','intent_id');
        } else {
            if (!empty($cat_id) && !empty($sub_cat_id)) {
                $data['lists'] = $this->common_model->get_common_list_bysortwithcount('zyra_intent', '*', 'cat_id', $cat_id, 'sub_cat_id', $sub_cat_id,$order,$order_by,'zyra_intent_examples','intent_id');
            } else {
                if (!empty($cat_id )) {
                    $data['lists'] = $this->common_model->get_common_list_bysortwithcount('zyra_intent', '*', 'cat_id', $cat_id, '', '',$order,$order_by,'zyra_intent_examples','intent_id');
                }
                if (!empty($sub_cat_id)) {
                    $data['lists'] = $this->common_model->get_common_list_bysortwithcount('zyra_intent', '*', 'sub_cat_id', $sub_cat_id, '', '',$order,$order_by,'zyra_intent_examples','intent_id');
                }
            }
        }

        if($user_type!='Admin'){
            $data['lists'] = array_filter($data['lists'], function($del_val)  {
                return ($del_val->count!=0);
            });
        }



        $intentLists = $this->load->view('intentengine/dropdown', $data, true);
        echo json_encode(['status' => true, 'html' => $intentLists]);
    } catch (Exception $e) {
        echo json_encode(['status' => false, 'html' => '']);
    }
}

    /**
     * Add Intent Category for admin
     * @Ajaxcall
     */
    public function addIntentCategory() {
        try {
            $session_id = $this->session->userdata('adminid_backend');
            $cat_name = trim($this->input->post('cat_name'));

            $intent_cat_id = trim($this->input->post('intent_cat_id'));

            if ($intent_cat_id != '') {
                $conditions = array('name' => $cat_name, 'id!=' => $intent_cat_id);
            } else {
                $conditions = array('name' => $cat_name);
            }
            $count = $this->common_model->get_count_by_multiple_condition('zyra_intent_category', $conditions);
            if ($count == 0) {
                if ($intent_cat_id == '') {
                    $data = array(
                        'name' => $cat_name,
                        'user_id' => $session_id,
                        'status' => 1
                    );
                    $insert = $this->common_model->store_data('zyra_intent_category', $data);
                } else {
                    $data = array(
                        'name' => $cat_name,
                    );
                    $conditions = array('id' => $intent_cat_id);
                    $this->common_model->update_data_multiple_condition('zyra_intent_category', $conditions, $data);
                }
                echo json_encode(['status' => true]);
            } else {
                echo json_encode(['status' => 'exist']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => false]);
        }
    }

    /**
     * Add Intent Sub Category for admin
     * @Ajaxcall
     */
    public function addIntentSubCategory() {
        try {
            $_POST = xss_clean($this->input->post());
            $session_id = $this->session->userdata('adminid_backend');
            $cat_id = $this->input->post('cat_id');

            $name = trim($this->input->post('name'));

            $intent_sub_cat_id = '';

            if (isset($_POST['intent_sub_cat_id'])) {
                $intent_sub_cat_id = $_POST['intent_sub_cat_id'];
            }
            if ($intent_sub_cat_id != '') { // in case of edit
                $conditions = array('name' => $name, 'cat_id' => $cat_id, 'id!=' => $intent_sub_cat_id);
            } else {
                $conditions = array('name' => $name, 'cat_id' => $cat_id);
            }
            $count = $this->common_model->get_count_by_multiple_condition('zyra_intent_sub_category', $conditions);
            if ($count == 0) {
                if ($intent_sub_cat_id == '') {
                    $data = array(
                        'name' => $name,
                        'cat_id' => $cat_id,
                        'user_id' => $session_id,
                        'status' => 1
                    );
                    $insert = $this->common_model->store_data('zyra_intent_sub_category', $data);
                } else { // in case of update
                    $data = array(
                        'name' => $name,
                        'cat_id' => $cat_id,
                    );
                    $conditions = array('id' => $intent_sub_cat_id);
                    $this->common_model->update_data_multiple_condition('zyra_intent_sub_category', $conditions, $data);
                    
                    $other_update=[
                        'cat_id'=>$cat_id
                    ];
                    $other_condition=[
                        'sub_cat_id'=>$intent_sub_cat_id
                    ];
                    $this->common_model->update_data_multiple_condition('zyra_intent', $other_condition, $other_update);
                    // update intent 
                    $this->common_model->update_data_multiple_condition('zyra_intent_examples', $other_condition, $other_update);
                    //and intent example table
                    
                    
                }
                echo json_encode(['status' => true]);
            } else {
                echo json_encode(['status' => 'exist']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => false]);
        }
    }

    /**
     * Add Intent Sub Category for admin
     * @Ajaxcall
     */
    public function addIntent() {
        try {
            $_POST = xss_clean($this->input->post());
            $session_id = $this->session->userdata('adminid_backend');
            $cat_id = $this->input->post('cat_id');
            $sub_cat_id = $this->input->post('sub_cat_id');

            $name = trim($this->input->post('name'));

            $intent_selected_id = '';

            if (isset($_POST['intent_sel_id'])) {
                $intent_selected_id = $_POST['intent_sel_id'];
            }


            if ($intent_selected_id != '') { // in case of edit
                $conditions = array('name' => $name, 'cat_id' => $cat_id, 'sub_cat_id' => $sub_cat_id, 'id!=' => $intent_selected_id);
            } else {
                $conditions = array('name' => $name, 'cat_id' => $cat_id, 'sub_cat_id' => $sub_cat_id);
            }


            $count = $this->common_model->get_count_by_multiple_condition('zyra_intent', $conditions);

            if ($count == 0) {
                if ($intent_selected_id == '') {
                    $data = array(
                        'name' => $name,
                        'cat_id' => $cat_id,
                        'sub_cat_id' => $sub_cat_id,
                        'user_id' => $session_id,
                        'status' => 1
                    );
                    $insert = $this->common_model->store_data('zyra_intent', $data);
                } else {
                    $data = array(
                        'name' => $name,
                        'cat_id' => $cat_id,
                        'sub_cat_id' => $sub_cat_id,
                    );
                    $conditions = array('id' => $intent_selected_id);
                    $this->common_model->update_data_multiple_condition('zyra_intent', $conditions, $data);
                    
                    $other_update=[
                       'cat_id' => $cat_id,
                       'sub_cat_id' => $sub_cat_id,
                   ];
                   $other_condition=[
                    'intent_id'=>$intent_selected_id
                ];

                    // update intent 
                $this->common_model->update_data_multiple_condition('zyra_intent_examples', $other_condition, $other_update);
                    //and intent example table
                $other_update=[
                   'cat_id' => $cat_id,
                   'sub_cat_id' => $sub_cat_id,
               ];
               $other_condition=[
                'intent_id'=>$intent_selected_id
            ];

                    // update intent 
            $this->common_model->update_data_multiple_condition('zyra_intent_examples', $other_condition, $other_update);
                    //and intent example table
        }
        echo json_encode(['status' => true]);
    } else {
        echo json_encode(['status' => 'exist']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => true]);
}
}

public function addIntentElement() {
    $data['module'] = $this->input->post('module');
    $intentLists = $this->load->view('intentengine/rightSideContent', $data, true);
    echo json_encode(['status' => true, 'html' => $intentLists]);
}

public function loadIntentLibrary() {

    try {
        $data = [];
        $intentLists = $this->load->view('intentengine/intentLibrary', $data, true);
        echo json_encode(['status' => true, 'html' => $intentLists]);
    } catch (Exception $e) {
        echo json_encode(['status' => false, 'html' => '']);
    }
}

public function addIntentExample() {
    try {
        $_POST = xss_clean($this->input->post());
        $session_id = decode_url_for_zyra($this->input->post('user_id'));
        $user_data = $this->common_model->get_common('zyra_user', 'user_type', 'user_id', $session_id, '', '');
        $intent_name=$this->input->post('intent_name');
        $user_type=$user_data->user_type;
        $title = trim($this->input->post('title'));
        $intent_id_input = trim($this->input->post('intent_id'));
        if($intent_id_input==0){
            $data_array=[
                'cat_id'=>0,
                'sub_cat_id'=>0,
                'name'=>$intent_name,
                'user_id'=>$session_id,
                'status'=>0
            ];
            $intent_id = $this->common_model->store_data_insert_id('zyra_intent', $data_array);    
        }else{
            $intent_id =$intent_id_input;
        }

        $intent_data = $this->common_model->get_common('zyra_intent', '*', 'id', $intent_id, '', '');
        if($user_type=='Admin'){
            $status=1;
        }else{
            $status=0;
        }
        $data = [
            'title' => $title,
            'intent_id' => $intent_data->id,
            'cat_id' => $intent_data->cat_id,
            'sub_cat_id' => $intent_data->sub_cat_id,
            'user_id' => $session_id,
            'status' => $status,
            'created_on' => date("Y-m-d H:i:s"),
            'updated_on' => date("Y-m-d H:i:s"),
        ];
        $this->common_model->store_data('zyra_intent_examples', $data);
        echo json_encode(['status' => true]);
    } catch (Exception $e) {
        echo json_encode(['status' => false]);
    }
}

public function loadAIView() {
    try {
        $data['count'] = $this->input->post('count');
        $data['intent_id'] = $this->input->post('intent_id');
        $data['branch_id'] = $this->input->post('branch_id');
        $data['cat_id'] = $this->input->post('cat_id');
        $data['sub_cat_id'] = $this->input->post('sub_cat_id');
        $data['unid'] = $this->input->post('unid');

        $data['type'] = 'AI';
        $intent_cat_id=$data['cat_id'];
        $intent_sub_cat_id=$data['sub_cat_id'];
        if(!empty($data['intent_id'] )){
            $intentdata=$this->common_model->get_common('zyra_intent','*','id',$data['intent_id'],'','');
            $intent_cat_id=$intentdata->cat_id;
            $intent_sub_cat_id=$intentdata->sub_cat_id;
        }
        if(!empty($data['branch_id'])){
          $data['branch_ai_string'] ="cat".$data['cat_id']."-subcat".$data['sub_cat_id']."-int".$data['intent_id'];  
      }else{
         $data['branch_ai_string']=""; 
     }

     $intentLists = $this->load->view('botbuilder/branchButtonContent', $data, true);
     echo json_encode(['status' => true, 'html' => $intentLists,'intent_cat'=>$intent_cat_id,'intent_sub_cat'=>$intent_sub_cat_id]);
 } catch (Exception $e) {
    echo json_encode(['status' => false, 'html' => '']);
}
}

function loadIntentExamples() {
    try {
        $session_id = decode_url_for_zyra($this->input->post('user_id'));

        $data['intent_id'] = $this->input->post('intent_id');
        $data['example_list'] = $this->bot_builder_model->getIntentExamples($data['intent_id'], '',20,$session_id,'');

            //$data['example_count'] = count($this->bot_builder_model->getIntentExamples($data['intent_id'], 'count','',$session_id,''));
        $postData['userLoginId'] = $session_id;
        $data['example_count'] = $this->bot_builder_model->count_filteredAtIntentEnginePage($postData);
        $data['allIntents'] = $this->bot_builder_model->getAllIntent($session_id);

            //zyra_intent_examples
        $intentLists = $this->load->view('intentengine/intentExamples', $data, true);
        echo json_encode(['status' => true, 'html' => $intentLists]);
    } catch (Exception $e) {
        echo json_encode(['status' => false, 'html' => '']);
    }
}

function deleteIntentExamples() {
    try {
        $deleteid = $this->input->post('delete_id');
        $data = explode(",", $deleteid);
        $intentLists = $this->bot_builder_model->deleteIntentExamples($data);
        echo json_encode(['status' => true, 'html' => '']);
    } catch (Exception $e) {
        echo json_encode(['status' => false, 'html' => '']);
    }
}

function updateIntentExamples() {
    try {
        $_POST = xss_clean($this->input->post());
        $deleteid = $this->input->post('id');
        $val = $this->input->post('val');
        $conditions = array('id' => $deleteid);
        $update_array = array('title' => $val,'updated_on'=>date("Y-m-d H:i:s"));

        $intentLists = $this->common_model->update_data_multiple_condition('zyra_intent_examples', $conditions, $update_array);
        echo json_encode(['status' => true, 'html' => '']);
    } catch (Exception $e) {
        echo json_encode(['status' => false, 'html' => '']);
    }
}

public function editIntentElement() {
    $data['module'] = $this->input->post('module');
    $data['id'] = $this->input->post('id');
    $value = array();
    if ($data['module'] == 'cat') {
        $result = $this->common_model->get_common('zyra_intent_category', '*', 'id', $data['id'], '', '');
        if (!empty($result)) {
            $value['cat_id'] = $result->id;
            $value['sub_cat_id'] = '';
            $value['name'] = $result->name;
        }
    }
    if ($data['module'] == 'subcat') {
        $result = $this->common_model->get_common('zyra_intent_sub_category', '*', 'id', $data['id'], '', '');
        if (!empty($result)) {
            $value['cat_id'] = $result->cat_id;
            $value['sub_cat_id'] = $result->id;
            $value['name'] = $result->name;
        }
    }
    if ($data['module'] == 'intent') {
        $result = $this->common_model->get_common('zyra_intent', '*', 'id', $data['id'], '', '');

        if (!empty($result)) {
            $value['cat_id'] = $result->cat_id;
            $value['sub_cat_id'] = $result->sub_cat_id;
            $value['intent_sel_id'] = $result->id;
            $value['name'] = $result->name;
        }
    }
    $data['value'] = $value;
    $intentLists = $this->load->view('intentengine/rightSideContent', $data, true);
    echo json_encode(['status' => true, 'html' => $intentLists, 'cat' => $value['cat_id'], 'sub_cat_id' => $value['sub_cat_id']]);
}

public function deleteIntentElement() {
    try {
        $data['module'] = $this->input->post('module');
        $data['id'] = $this->input->post('id');
        $value = array();
        if ($data['module'] == 'cat') {
            $this->common_model->delete_data('zyra_intent_category', 'id', $data['id']);
            $this->common_model->delete_data('zyra_intent_sub_category', 'cat_id', $data['id']);
            $this->common_model->delete_data('zyra_intent', 'cat_id', $data['id']);
            $this->common_model->delete_data('zyra_intent_examples', 'cat_id', $data['id']); 
        }
        if ($data['module'] == 'subcat') {
            $this->common_model->delete_data('zyra_intent_sub_category', 'id', $data['id']);
            $this->common_model->delete_data('zyra_intent', 'sub_cat_id', $data['id']);
            $this->common_model->delete_data('zyra_intent_examples', 'sub_cat_id', $data['id']);
        }
        if ($data['module'] == 'intent') {
            $this->common_model->delete_data('zyra_intent', 'id', $data['id']);
            $this->common_model->delete_data('zyra_intent_examples', 'intent_id', $data['id']);
        }
        echo json_encode(['status' => true]);
    } catch (Exception $e) {
        echo json_encode(['status' => false, 'html' => '']);
    }
}

    /**
     * get Example list with selected intent id
     * @Ajaxcall
     */
    function selectIntentAIRules() {
       try {
        $user_id  =   decode_url_for_zyra($this->input->post('user_id'));
        $userinfo= $this->common_model->get_common('zyra_user','*','user_id',$user_id,'','');
        $intentLists=""; 

//            if($userinfo->user_type=="User"){
//            $data['intent_id'] = $this->input->post('intent_id');
//            $data['example_list'] = $this->bot_builder_model->getIntentExamples($data['intent_id'],1,3,'',1);
//            //zyra_intent_examples
//            $intentLists = $this->load->view('botbuilder/aiSetUpExamples', $data, true);
//            }else{
//              $intentLists="";  
//            }
        echo json_encode(['status' => true, 'html' => $intentLists]);
    } catch (Exception $e) {
        echo json_encode(['status' => false, 'html' => '']);
    }
}

function getIntentAIRules(){
  $cat_id = $this->input->post('cat_id');
  $subcat_id = $this->input->post('sub_cat_id'); 
  $search = $this->input->post('search');
  $data['intent_list'] = $this->bot_builder_model->getIntentList($cat_id, $subcat_id,$search);
  echo  json_encode($data['intent_list']);
}


public function userIntentEngine() {
    if ($this->session->userdata('user_type_user') == 'User' && $this->uri->segment(1) == 'user') {
        $userinfo = $this->common_model->get_common('zyra_user', '*', 'user_id', $this->session->userdata('userid'), '', '');
        if($userinfo->feature=='freemium') { redirect('user/dashboard'); }
    }
    $data['activeSidebar'] = 'intentengine';
    $data['page_title'] = 'Intent Engine';
    $data['main_content'] = 'intentengine/userintentEngine';
    $data['data_show'] = false;
    $data['created_user_id']=$this->session->userdata('userid');
    $template_type = 'template_user';
    $data['subcategory'] = $this->common_model->get_common_list_bysort('zyra_intent_sub_category', '*', 'id>', '0', '', '','asc','name');
    $this->load->view("includes/$template_type", $data);
}

function getCustomContextData(){
    $chatBot_id = $this->input->post('chatBot_id');
    $this->getCustomContextDataAll($chatBot_id);
}

function getCustomContextDataAll($chatBot_id) {
    $this->db->select('cahtversion')->from('zyra_user');
    $this->db->where('chatBot_id', $chatBot_id);
    $query1 = $this->db->get();
    $resultUser = $query1->row();

    $adminVariable = $this->getCustomContextVariableDataAdmin($chatBot_id, $resultUser->cahtversion);
    $resultVariable = $this->getCustomContextVariableData($chatBot_id, $resultUser->cahtversion);
    $finalVariable = array_merge($adminVariable, $resultVariable);

        // Set Remodel variable Start
    $itemS = array('FireDamage', 'MoldDamage', 'GeneralDamage', 'FloodDamage', 'Remodels');
    $k = 0;
    foreach ($itemS as $strval) {
        if (array_search($strval, array_column($finalVariable, 'variable')) !== false) {
            $k++;
        }
    }
    if ($k == 5) {
        if (array_search('Remodels', array_column($finalVariable, 'variable')) !== false) {

        } else {
            array_push($finalVariable, array('variable' => 'Remodels', 'value' => 'true'));
        }
    } else {
        if (array_search('Remodels', array_column($finalVariable, 'variable')) !== false) {
            $arrKey2 = array_search('Remodels', array_column($finalVariable, 'variable'));
            unset($finalVariable[$arrKey2]);
            $finalVariable = array_values($finalVariable);
        }
    }
        // Set Remodel variable End
    @array_unique($finalVariable);
    echo json_encode(array('result' => $finalVariable));
}

function getCustomContextVariableDataAdmin($chatBot_id, $cahtversion) {
    $this->db->select('variable,value');
    $this->db->from('zyra_adminbot_config');
    $this->db->where("`variable` NOT IN (SELECT `variable` FROM `zyra_adminbot_config_userwise` where `chatbot_version` =  '$cahtversion'  and `chatBot_id` = '$chatBot_id' )", NULL, FALSE);
    $this->db->where('to_be_compare', '1');
    $this->db->where('chatbot_version', $cahtversion);
    $query1 = $this->db->get();
    return $query1->result();
}

function getCustomContextVariableData($chatBot_id, $cahtversion) {
    $this->db->select('variable,value');
    $this->db->from('zyra_adminbot_config_userwise');
    $this->db->where('chatBot_id', $chatBot_id);
    $this->db->where('chatbot_version', $cahtversion);
    $query1 = $this->db->get();
    return $query1->result();
}



function connectIBMWatson() {
    $msg = $this->input->post('msg');
    $context = $this->input->post('context'); 
        //$final_arr = ibmWatsonReply($msg,$context);
    $final_arr = ibmWatsonIntents($msg,$context);
    echo $final_json = json_encode($final_arr);
}

function exportIntentAndCategoriesAtAdmin(){

    $data['category'] = $this->input->post('category');
    $data['subCategory'] = $this->input->post('subCategory');
    $data['intents'] = $this->input->post('intents');

    $file = exportIntentAndCategories($data);
    $filePath = FCPATH."assets/tempFile/".$file;
    downloadFileExcel($filePath);
}

function testDownload(){
    $filePath = FCPATH."assets/tempFile/export.xlsx";
    downloadFileExcel($filePath);
}

function approveIntentExample(){
    $data['activeSidebar'] = 'approveIntentExample';
    $data['page_title'] = 'Suggested Examples';
    $data['main_content'] = 'intentengine/approveIntentExample';
    $template_type = 'template_admin';
    $this->load->view("includes/$template_type", $data);
}

public function intentExampleList() {
    $postData = array();
    $postData['strsearch'] = trim(strip_tags($this->input->post('strsearch')));
    $time_zone = $this->input->post('time_zone');
    $time_zone_arr = explode(":", $time_zone);
    date_default_timezone_set('GMT');

    $this->result = $this->bot_builder_model->getIntentExampleList($postData);
//        $this->result = $this->Appointment_model->getAMChatList($postData);
    $this->tableData = array();
    if ($this->result) {
        foreach ($this->result as $al) {

            $row = array();
            $row[] = '<label  class="mt-checkbox mt-checkbox-single mt-checkbox-outline"><input type="checkbox" value="'.$al['example_id'].'" name="examples[]" ><span></span></label>';

            $example = '<div id="int_exm_'.$al['example_id'].'"><div class="intent_title">'.trim($al['title']).'</div><div style="width:100%;" class="form-group form-md-line-input form-md-floating-label has-info textIntentEdit">
            <input class="form-control  edited" name="intent_name" value="'.trim($al['title']).'"  onchange="updateExampleText(this);"> 
            </div></div>';

            $row[] = $example;
            $row[] = (trim($al['intent_name']) != '') ? trim($al['intent_name']) : '';
            $row[] = (trim($al['cat_name']) != '') ? trim($al['cat_name']) : '';
            $row[] = (trim($al['sub_cat_name']) != '') ? trim($al['sub_cat_name']) : '';
            $row[] = (trim($al['company']) != '') ? trim($al['company']) : '';
            $action = '';
            if(!empty($al['cat_name'])){
                $action.= '<button id="BTNAPPROVE_1_' . $al['example_id'] . '" onclick="approveIntentExample(' . $al['example_id'] . ')" type="button" class="btn green">Approve</button>';
            }
            $action.= '<button id="BTNDELETE_' . $al['example_id'] . '" onclick="rejectIntentExample(' . $al['example_id'] . ')" type="button" class="btn btn-primary">Delete</button>';
            $actionHTml = "<div id=VAS_" . $al['example_id'] . ">".$action."</div>";
            $row[] = $actionHTml;                
            $this->tableData[] = $row;
        }
    }
    $output = array(
        "draw" => $this->input->post('draw'),
        "recordsTotal" => $this->bot_builder_model->count_all($postData),
        "recordsFiltered" => $this->bot_builder_model->count_filtered($postData),
        "data" => $this->tableData,
        'strSearch' => $postData['strsearch'],
    );

    /* output to json format */
    echo json_encode($output);
}

function approveRejectIntentExampleNow(){
    $example_id = $this->input->post('example_id');
    $type = $this->input->post('type');
    $this->bot_builder_model->approveRejectIntentExampleMF($example_id,$type);
    echo 1;
}


function getTargetedBranchDetail(){
    try{
        $workspace_id = decode_url_for_zyra($this->input->post('workspace_id'));
        $branch_id = $this->input->post('branch_id');
        $details=$this->bot_builder_model->getTargetedBranchDetail($workspace_id,$branch_id);
        $html="";
        if (!empty($details)) {
            $html='<p >All branches that have set up this branch in the setting "<b>if no AI is analyzed, Go to Branch</b>" will be set up empty. List of branches is given below.';
            $html.='<ul class="targetbranchul">';
            foreach ($details as $detail) {
                $html.='<li> '.$detail->branch_name.'</li>';
            }
            $html.='</ul> ';
        }
        echo json_encode(['status' => true, 'html' => $html]);
    } catch (Exception $e) {
        echo json_encode(['status' => false, 'html' => '']);
    }
}


public function intentExampleListAtIntentEnginePage() {

    $userLoginId = decode_url_for_zyra($this->input->post('created_user_id'));
    $postData = array();
    $postData['strsearch'] = trim(strip_tags($this->input->post('strsearch')));
    $postData['intent'] = trim(strip_tags($this->input->post('intent')));
    $postData['userLoginId'] = $userLoginId;
    $time_zone = $this->input->post('time_zone');
    $time_zone_arr = explode(":", $time_zone);
    date_default_timezone_set('GMT');

    $this->result = $this->bot_builder_model->intentExampleListAtIntentEnginePage($postData);
//        $this->result = $this->Appointment_model->getAMChatList($postData);
    $this->tableData = array();
    if ($this->result) {
        foreach ($this->result as $al) {

            $row = array();
            $row[] = '<label  class="mt-checkbox mt-checkbox-single mt-checkbox-outline"><input type="checkbox" value="'.$al['example_id'].'" name="examples[]" ><span></span></label>';

            $example = '<div id="int_exm_'.$al['example_id'].'"><div class="intent_title">'.trim($al['title']).'</div><div  style="width:100%;" class="form-group form-md-line-input form-md-floating-label has-info textIntentEdit">
            <input id="editIntentExampleWrap" class="form-control  edited" name="intent_name" value="'.trim($al['title']).'"  onchange="updateExampleText(this);"> 
            </div></div>';

            $row[] = $example;
            $row[] = (trim($al['intent_name']) != '') ? trim($al['intent_name']) : '';
            $action = '';
            $action.= '<button id="BTNAPPROVE_1_' . $al['example_id'] . '" onclick="approveIntentExample(' . $al['example_id'] . ')" type="button" class="btn green">Approve</button>';
            $action.= '<button id="BTNDELETE_' . $al['example_id'] . '" onclick="rejectIntentExample(' . $al['example_id'] . ')" type="button" class="btn btn-primary">Delete</button>';
            $actionHTml = "<div id=VAS_" . $al['example_id'] . ">".$action."</div>";
            $row[] = $actionHTml;                
            $this->tableData[] = $row;
        }
    }
    $output = array(
        "draw" => $this->input->post('draw'),
        "recordsTotal" => $this->bot_builder_model->count_allAtIntentEnginePage($postData),
        "recordsFiltered" => $this->bot_builder_model->count_filteredAtIntentEnginePage($postData),
        "data" => $this->tableData,
        'strSearch' => $postData['strsearch'],
    );

    /* output to json format */
    echo json_encode($output);
}

     /**
     * Check if User has made changes 
     * @Ajaxcall
     */

     function checkLastUpdatedTime(){

       $workspace_id= decode_url_for_zyra($this->input->post('workspace_id'));

       $latest_update_branch_time = $this->bot_builder_model->getLatestUpdateBranchTime($workspace_id);   
       $workspace_detail=$this->common_model->get_common('zyra_workspace','preview_date','auto_id',$workspace_id,'','');
       $dateTimestamp1 = strtotime($latest_update_branch_time->updated_at);  
       $dateTimestamp2 = strtotime($workspace_detail->preview_date); 
       $show=false;
       if(empty($workspace_detail->preview_date)){
           $show = false;
       }else{
         if($dateTimestamp1 > $dateTimestamp2){ 
           $show = true;
       }  
   }
   echo $show;
   exit;

}

    /**
     * Function to duplicate workspace  
     * Return added workspaces id
     */
    
    public function duplicateWorkspace() {
        try {
            $workspace_id = decode_url_for_zyra($this->input->post('workspace_id'));
            $created_user_id = decode_url_for_zyra($this->input->post('created_user_id'));
            $workspace_conv_type = $this->input->post('workspace_conv_type');
            $workspace_assign = $this->bot_builder_model->duplicateWorkspace($workspace_id,$created_user_id,json_decode($workspace_conv_type));
            echo json_encode(['status' => true, 'added_workspace_id' => $workspace_assign]);
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'added_workspace_id' => '']);
        }
    }
    
    function addSingleBranches(){
       $workspace_id = decode_url_for_zyra($this->input->post('workspace_id'));
       $user_id = decode_url_for_zyra($this->input->post('user_id'));
       $position = $this->bot_builder_model->getLastBranchPosition($workspace_id);
       $data_to_push=array(
        'branch_name'=>'Untitled',
        'workspace_id'=>$workspace_id,
        'user_id'=>$user_id,
        'validation'=>'',
        'status'=>0,
        'created_at'=>date("Y-m-d H:i:s"),
        'position'=>$position+1,
        'capture_as'=>'',
        'target_branch' => '', 
        'is_end' =>'N',
        'team_profile'=>0,
        'team_workspace_members'=>0

    ); 


       if(!empty($data_to_push)){
          $insert_id=$this->common_model->store_data_insert_id('zyra_workspace_dialog_branches',$data_to_push); 
          
          if (!empty($insert_id)) {

            $queshpush = array(
                'question' => 'Untitled Question edit branch question',
                'branch_id' => $insert_id,
                'workspace_id' => $workspace_id,
                'user_id' => $user_id,
                'status' => 0
            );

            $this->common_model->store_data_insert_id('zyra_workspace_dialog_branch_questions', $queshpush);
        }

        echo json_encode(['status' => 'success','branch_id'=>$insert_id]);
    }else{
      echo json_encode(['status' => 'error']);   
  }   
}

function getChosenBranchAIrules(){
 try {
    $branch_id = $this->input->post('branch_id');
    $existing_arr = json_decode($this->input->post('existing_arr'));
    $existing_branch_id =$this->input->post('existing_branch_id');
    $metalists = $this->bot_builder_model->branchAIRules($branch_id);
    foreach ($metalists as $key => $metalist) {
        $string = "cat" . $metalist->cat_id . "-subcat" . $metalist->sub_cat_id . "-int" . $metalist->intent_id;
        $metalists[$key]->string = $string;
    }

    $keyArray = [];
    if (!empty($existing_arr)) {
        foreach ($existing_arr as $existing) {
            $key2 = array_search(trim($existing), array_column($metalists, 'string'));

            if (false !== $key2) {
                $keyArray[] = $key2;
            }
        }
    }
    if (!empty($keyArray)) {
        foreach ($keyArray as $val) {
            unset($metalists[$val]);
        }
    }


    if(!empty($existing_branch_id)){
        $insert_topush=[];
        foreach($metalists as $metal){
            $push_arr=[
                'intent_id'=>$metal->intent_id,
                'intent_branch_id'=>$metal->intent_branch_id,
                'branch_id' =>$existing_branch_id,
                'workspace_id' =>$metal->workspace_id,
                'user_id'=>$metal->user_id,
                'status'=>$metal->status,
                'cat_id'=>$metal->cat_id,
                'sub_cat_id'=>$metal->sub_cat_id,
            ];
            array_push($insert_topush, $push_arr);   
        }
        $this->common_model->insertBatch('zyra_workspace_dialog_branches_ai_rules', $insert_topush);  
    }


    $meta['ai_list'] = $metalists;
    $branch_ai_html = $this->load->view("botbuilder/branchAIRules", $meta, true);
    echo json_encode(array("res" => 'success', 'msg' => 'Branch added successfully.', 'branch_ai_html' => $branch_ai_html, 'meta_list' => array_values($metalists)));
} catch (Exception $e) {
    echo json_encode(array("res" => 'success', 'msg' => $e->getMessage(), 'id' => $auto_id));
}
}


public function loadResponseQuestion() {
    try {

        $data['unid'] = $this->input->post('unid');
        $data['val'] = $this->input->post('val');
        $data['subtype'] = $this->input->post('subtype');
        $data['question_id'] = $this->input->post('question_id');
        $data['type'] = 'QuestionResponse';
        $intentLists = $this->load->view('botbuilder/branchButtonContent', $data, true);
        echo json_encode(['status' => true, 'html' => $intentLists]);
    } catch (Exception $e) {
        echo json_encode(['status' => false, 'html' => '']);
    }
}


public function saveBranchAIRules() {
    try {
        $branch_id = $this->input->post('branch_id');
        $workspaceid = decode_url_for_zyra($this->input->post('workspace_id'));
        $user_id = decode_url_for_zyra($this->input->post('created_user_id'));
        $update_branchai_rule=$this->input->post('update_branchai_rule');


        if (!empty($branch_id)) {
            $saveArr = json_decode($this->input->post('saveArr'));
            $aiRulesinsert = [];
            if(!empty($update_branchai_rule)){
              $delcatdetail = explode('-', $update_branchai_rule);
              $delintent_id=str_replace("int", "", $delcatdetail['2']);
              $delcat_id=str_replace("cat", "", $delcatdetail['0']);
              $delsubcat_id=str_replace("subcat", "", $delcatdetail['1']);
              $conditions=array(
                  'intent_id'=>$delintent_id,
                  'cat_id'=>$delcat_id,
                  'sub_cat_id'=>$delsubcat_id,
                  'branch_id'=>$branch_id,
                  'workspace_id'=>$workspaceid,
              );

              $this->common_model->delete_data_by_multiple_condition('zyra_workspace_dialog_branches_ai_rules', $conditions);
          }
          foreach ($saveArr as $save) {
            $catdetail = explode('-', $save->string);
            $aipush = array(
                'intent_id' => str_replace("int", "", $catdetail['2']),
                'intent_branch_id' => $save->branch_id,
                'branch_id' => $branch_id,
                'workspace_id' => $workspaceid,
                'user_id' => $user_id,
                'status' => 0,
                'cat_id' => str_replace("cat", "", $catdetail['0']),
                'sub_cat_id' => str_replace("subcat", "", $catdetail['1']),
            );
            array_push($aiRulesinsert, $aipush);
        }

        if ($this->common_model->insertBatch('zyra_workspace_dialog_branches_ai_rules', $aiRulesinsert)) {
            $meta['ai_list'] = $this->bot_builder_model->branchAIRules($branch_id);
            $branch_ai_html = $this->load->view("botbuilder/branchAIRules", $meta, true);
            echo json_encode(['status' => true, 'html' => $branch_ai_html]);
        } else {
            echo json_encode(['status' => false, 'html' => '']);
        }
    }
} catch (Exception $e) {
    echo json_encode(['status' => false, 'html' => '']);
}
}

public function saveResponseToQuestions(){
  try {
    $branch_id = $this->input->post('branch_id');
    $workspaceid = decode_url_for_zyra($this->input->post('workspace_id'));
    $user_id = decode_url_for_zyra($this->input->post('created_user_id'));
    $response_question_id=$this->input->post('response_question_id');
    $flag=false;

    if (!empty($branch_id)) {
        $questionResponses = json_decode($this->input->post('questionArr'));

        $aiRulesinsert = [];
        if(!empty($response_question_id)){

          $conditions=array(
              'id'=>$response_question_id,

          );
          $update=[
              'question'=>$questionResponses[0]->question
          ];

          $this->common_model->update_data_multiple_condition('zyra_workspace_question_reponse', $conditions,$update);
          $flag=true;
      }else{

         if(!empty($questionResponses)){
            $insertQuestionResponse = array();
            foreach ($questionResponses as $question) {
                $queshpushres = array(
                    'question' => $question->question,
                    'branch_id' => $question->branch_id,
                    'workspace_id' => $workspaceid,
                    'user_id' => $user_id,
                    'status' => 1,
                    'created_at'=>date("Y-m-d H:i:s")
                );
                array_push($insertQuestionResponse, $queshpushres);
            }


        }
        if ($this->common_model->insertBatch('zyra_workspace_question_reponse', $insertQuestionResponse)) {
            $flag=true;
        }
    }
    if ($flag) {
        $meta_reponse['question_response_list'] = $this->common_model->get_common_list('zyra_workspace_question_reponse','*','branch_id',$branch_id,'','');
        $question_response_list_html = $this->load->view("botbuilder/questionResponse", $meta_reponse, true);
        echo json_encode(['status' => true, 'html' => $question_response_list_html]);
    } else {
        echo json_encode(['status' => false, 'html' => '']);
    }
}
} catch (Exception $e) {
    echo json_encode(['status' => false, 'html' => '']);
}
}

public function deleteAIRule(){
    $airule_id = $this->input->post('ai_rule_id');
    $conditions=[
        'id'=>$airule_id
    ];
    $this->common_model->delete_data_by_multiple_condition('zyra_workspace_dialog_branches_ai_rules', $conditions);
    echo json_encode(['status' => true]);
}

public function deleteQuestionResponse(){
    $question_id = $this->input->post('question_id');
    $conditions=[
        'id'=>$question_id
    ];
    $this->common_model->delete_data_by_multiple_condition('zyra_workspace_question_reponse', $conditions);
    echo json_encode(['status' => true]);
}

public function getTestingView() {
    try {
        $_POST = xss_clean($this->input->post());
        $workspace_id = decode_url_for_zyra($this->input->post('wid'));
        $chatKey = decode_url_for_zyra($this->input->post('user_id'));
        $custom_builder_data = $this->bot_builder_model->getWelcomeData($chatKey, $workspace_id);
        $userinfo= $this->common_model->get_common('zyra_user', '*', 'user_id', $chatKey, '', '');
        $buttonflag=0;
        $review=$this->bot_builder_model->get_multiple_review_location($chatKey);
        $html = "";
        if (!empty($custom_builder_data)) {
            if (!empty($custom_builder_data[0]->branch_questions)) {
                $count = 0;
                foreach ($custom_builder_data[0]->branch_questions as $questions) {
                    $mapiconRight = "";
                    if ($count == 0) {
                        $mapiconRight = "mapiconRight";
                        $mapiconhtml='<a onclick="jumpToBracnh('.$custom_builder_data[0]->branch_id.')"><i class="fa fa-map-marker yr-faMapIcon" aria-hidden="true"></i></a>';
                    }else{
                        $mapiconhtml=""; 
                        $mapiconRight="";
                    }
                        // option_tile_replace=option_tile_replace.replace('COMPANY_NAME',zt.vars.orgName);
                            //option_tile_replace=option_tile_replace.replace("PHONE_NUMBER", '<a href="#" onclick="showPhone(\'' + zt.vars.companyTel + '\')">' + zt.vars.companyTel + '</a>');

                    $phone=str_replace('(','',$userinfo->phone);
                    $phone=str_replace(')','',$phone);
                    $phone=str_replace('-','',$phone);

                    $question_to_do=$questions->question;
                    $question_to_do=str_replace("COMPANY_NAME",$userinfo->company,$question_to_do);
                    $question_to_do=str_replace("PHONE_NUMBER",'<a href="#" onclick="showPhone('.$phone.')">' .$userinfo->phone. '</a>',$question_to_do);
                    $html .= '<div class="yr-TextArea ' . $mapiconRight . '">
                    <div class="yr-textSec"> ' . nl2br($question_to_do) . '</div>'.$mapiconhtml.'
                    </div>';
                    $count++;
                }

            }

            $html .= "<ul>";
            if (!empty($custom_builder_data[0]->branch_buttons)) {

                foreach ($custom_builder_data[0]->branch_buttons as $buttons) {
                    $mapiconRight = "";


                    $btntype = $buttons->button_respond_on;

                    $msgval = $buttons->button_title;

                        //Echo '<a href= "#" onClick= showDetails("'.$node.'");>'. $insert .'</a> ';

                    if ($btntype == 'Branch') {
                        $btntvalue = $buttons->button_respond_on_branch;
                        $buttonflag=1;
                        $html .= '<li><a href=# onclick="chatSendOnClick(\'' . string_sanitize($msgval) . '\',\'' . $btntvalue . '\')">' . $msgval . '</a></li>';
                    }
                    if ($btntype == 'PhoneCall') {
                        $countrycode=$buttons->button_respond_on_phonecall_country_code;
                        $btntvalue = $countrycode.$buttons->button_respond_on_phonecall;
                        $html .= '<li><a href=# onclick="showPhone(\'' . $btntvalue . '\',this)">' . $msgval . '</a></li>';
                    }
                    if ($btntype == "URL") {
                        $btntvalue = $buttons->button_respond_on_url;
                        $html .= '<li><a class="linked_button" onclick="link_clicked(\'' . $btntvalue . '\')" >' . $msgval . '</a></li>';
                    }
                    if ($btntype == 'SMS') {
                        $countrycode=$buttons->button_respond_on_phonecall_country_code;
                        $btntvalue = $countrycode.$buttons->button_respond_on_sms;
                        $html .= '<li><a href=# onclick="showSMS(\'' . $btntvalue . '\',this)">' . $msgval . '</a></li>';
                    }

                    if ($btntype == 'REVIEW' && !empty($review)) {

                        $btntvalue = $countrycode.$buttons->button_respond_on_review;
                        $btnlocation = $countrycode.$buttons->button_review_location;

                        $html .= '<li><a href=# onclick="loadReviewData(\'' . $btntvalue . '\',\'' . $msgval . '\')">' . $msgval . '</a></li>';
                    }



                }
            }
            $html .= "</ul>";

            $branch_options=$this->bot_builder_model->multiple_choice_options($custom_builder_data[0]->branch_id);
            $html_options="";
            if(!empty($branch_options)){
              $buttonflag=1;
              $html_options='<div class="yr-checkboxnewdesign">';

              $options_detail=$branch_options['option'];
              $target_option_id=$branch_options['target_branch_id'];
              $confirmtion_button=$branch_options['confirmation_button'];
              foreach($options_detail as $key=>$option){
               $html_options .='<div class="yr-checkBtn"><label class="mt-checkbox mt-checkbox-outline"> <input type="checkbox" value="'.$option.'" name="test">'.$option.'  <span></span> </label></div>';
           }

           $html_options .='<div class="yr-confirmBtn"><button type="button" onclick="chatSendOnconfirmation(this,\'' . $target_option_id . '\')">'.$confirmtion_button.'</button></div></div>';

       }
       $html .= $html_options;

       $validationData = $this->db->select('branch_id')
       ->where('workspace_id',$workspace_id)
       ->where("user_id",$chatKey)
       ->where('capture_as','phonenumber')
       ->get("zyra_workspace_dialog_branches")
       ->row();

       $phoneValidationBranchId = 0;
       if ( !empty($validationData) ){
        $phoneValidationBranchId = $validationData->branch_id;
    }

    echo json_encode(['status' => true,'phoneValidatorBranchId'=>$phoneValidationBranchId, 'html' => $html,'branch_id'=>$custom_builder_data[0]->branch_id,'buttonflag'=>$buttonflag]);
} else {
    echo json_encode(['status' => true, 'html' => '','branch_id'=>'']);
}
} catch (Exception $e) {
    echo json_encode(['status' => true, 'html' => '','branch_id'=>'']);
}
}

public function getWatsonData() {
    $_POST = xss_clean($this->input->post());
    $workspace_id = decode_url_for_zyra($this->input->post('wid'));
    $chatKey = decode_url_for_zyra($this->input->post('user_id'));
    $custom_builder_data = $this->bot_builder_model->getWelcomeData($chatKey, $workspace_id);
    $review=$this->bot_builder_model->get_multiple_review_location($chatKey);
    $msg = $this->input->post('msg');
    $captured_as=$this->input->post('capturedas');
    $candidateName=$this->input->post('candidateName');
    $name_captured_msg='';
    if($captured_as=='name'){
       $name= explode(' ', $msg);
       $candidateName=strip_tags($name[0]);

   }
   $branch_id = $this->input->post('branch_id');
   $branch_type = $this->input->post('branch_type');
   $checkzipcaptured = $this->input->post('checkzipcaptured');
   $identify_request = true;
   $output = getOutPutGenric($branch_id, $chatKey, $workspace_id, trim($msg), $identify_request, $branch_type,$checkzipcaptured,$candidateName);
   $userinfo= $this->common_model->get_common('zyra_user', '*', 'user_id', $chatKey, '', '');
   $buttonflag=0;
   try {

    $yes = (isQuestion($msg)) ? 'Yes' : 'No';
    $lists = $this->common_model->get_common_list_bysort('zyra_intent', '*', 'id>', '0', '', '', 'asc', 'name');
    $options = "";
    $selected_inetent_id = (!empty($output['intents_detail'][0]->id) && isset($output['intents_detail'][0]->id)) ? $output['intents_detail'][0]->id : '';

    if (!empty($lists)) {
        $options .= "<select><option value=''>Select Intent</option>";
        foreach ($lists as $list) {
            $selected = ($selected_inetent_id == $list->id) ? 'selected' : '';
            $options .= "<option value=" . $list->id . " $selected>$list->name</option>";
        }
        $options .= "</select>";
    }
    $html = '<div class="yr-TextBox ">
    <div class="yr-texttitle "> ' . $msg . '</div>
    <div class="eyeiconRight">
    ' . $options . '
    <p>Question Detected = ' . $yes . '</p>
    <a class="yr-faEyeIcon" onclick="addSuggestedIntent(this)"><i class="fa fa-eye " aria-hidden="true"></i></a>    
    </div>
    </div>';

    $str_array = [];

    $outputArr = $output['generic'];
    $branch_id = $output['branch_id'];
    $mapicon = false;
    for ($k = 0; $k < count($outputArr); $k++) {
        if ($outputArr[$k]->response_type == 'text') {

            if (!$mapicon) {
                $mapiconRight = "mapiconRight";
                $maphtml='<a class="yr-faMapIcon" onclick="jumpToBracnh('.$branch_id.')"><i class="fa fa-map-marker " aria-hidden="true"></i></a>';
                $mapicon = true;
            } else {
                $mapiconRight = "";
                $maphtml="";
            }

            $msg = $outputArr[$k]->text;

            $phone=str_replace('(','',$userinfo->phone);
            $phone=str_replace(')','',$phone);
            $phone=str_replace('-','',$phone);

            $question_to_do=$msg;
            $question_to_do=str_replace("COMPANY_NAME",$userinfo->company,$question_to_do);
            $question_to_do=str_replace("PHONE_NUMBER",'<a href="#" onclick="showPhone('.$phone.')">' .$userinfo->phone. '</a>',$question_to_do);
            if(!empty($candidate_name)){
              $question_to_do=str_replace("CHAT_NAME",$candidate_name,$question_to_do); 
          }



          $localhtml = '<div class="yr-TextArea ' . $mapiconRight . '">
          <div class="yr-textSec"> ' . $question_to_do . '</div>'.$maphtml.'
          </div>';
          $str_array[$k] = $localhtml;
      } elseif ($outputArr[$k]->response_type == 'option') {
        $localhtml = "";

        if (!$mapicon) {
            $mapiconRight = "mapiconRight";
            $maphtml='<a onclick="jumpToBracnh('.$branch_id.')"><i class="fa fa-map-marker yr-faMapIcon" aria-hidden="true"></i></a>';
            $mapicon = true;
        } else {
            $mapiconRight = "";
            $maphtml="";
        }
        $title = $outputArr[$k]->title;
        if ($title != '') {

            $phone=str_replace('(','',$userinfo->phone);
            $phone=str_replace(')','',$phone);
            $phone=str_replace('-','',$phone);

            $question_to_title=$title;
            $question_to_title=str_replace("COMPANY_NAME",$userinfo->company,$question_to_title);
            $question_to_title=str_replace("PHONE_NUMBER",'<a href="#" onclick="showPhone('.$phone.')">' .$userinfo->phone. '</a>',$question_to_title);
            if(!empty($candidate_name)){
              $question_to_do=str_replace("CHAT_NAME",$candidate_name,$question_to_do); 
          }





          $localhtml .= '<div class="yr-TextArea ' . $mapiconRight . '">
          <div class="yr-textSec"> ' . $question_to_title . '</div>'.$maphtml.'
          </div>';
      }
      $localhtml .= "<ul>";

      for ($i = 0; $i < count($outputArr[$k]->options); $i++) {
        $msg = $outputArr[$k]->options[$i]->label;
        $btntype = $outputArr[$k]->options[$i]->type;
        $btntvalue = $outputArr[$k]->options[$i]->btnvalue;
        $msgval = $outputArr[$k]->options[$i]->value->input->text;

                        //Echo '<a href= "#" onClick= showDetails("'.$node.'");>'. $insert .'</a> ';

        if ($btntype == 'Branch') {
            $buttonflag=1;
            $localhtml .= '<li><a href=# onclick="chatSendOnClick(\'' . string_sanitize($msgval) . '\',\'' . $btntvalue . '\')">' . $msgval . '</a></li>';
        }
        if ($btntype == 'PhoneCall') {

            $localhtml .= '<li><a href=# onclick="showPhone(\'' . $btntvalue . '\',this)">' . $msgval . '</a></li>';
        }
        if ($btntype == "URL") {
            $localhtml .= '<li><a class="linked_button" onclick="link_clicked(\'' . $btntvalue . '\')" ">' . $msgval . '</a></li>';
        }

        if ($btntype == 'SMS') {

            $localhtml .= '<li><a href=# onclick="showSMS(\'' . $btntvalue . '\',this)">' . $msgval . '</a></li>';
        }

        if ($btntype == 'REVIEW' && !empty($review)) {

//                            $btntvalue = $countrycode.$buttons->button_respond_on_review;
//                            $btnlocation = $countrycode.$buttons->button_review_location;

            $localhtml .= '<li><a href=# onclick="loadReviewData(\'' . $btntvalue . '\',\'' . $msgval . '\')">' . $msgval . '</a></li>';
        }


    }
    $localhtml .= "</ul>";
    $str_array[$k] = $localhtml;
}
}
foreach ($str_array as $str) {
    $mapiconRight = "";

    $html .= $str;
}

$branch_options=$this->bot_builder_model->multiple_choice_options($branch_id);
$html_options="";
if(!empty($branch_options)){
   $buttonflag=1;
   $html_options='<div class="yr-checkboxnewdesign">';

   $options_detail=$branch_options['option'];
   $target_option_id=$branch_options['target_branch_id'];
   $confirmtion_button=$branch_options['confirmation_button'];
   foreach($options_detail as $key=>$option){
       $html_options .='<div class="yr-checkBtn"><label class="mt-checkbox mt-checkbox-outline"> <input type="checkbox" value="'.$option.'" name="test">'.$option.'  <span></span> </label></div>';
   }

   $html_options .='<div class="yr-confirmBtn"><button type="button" onclick="chatSendOnconfirmation(this,\'' . $target_option_id . '\')">'.$confirmtion_button.'</button></div></div>';

}
$html .= $html_options;




echo json_encode(['status' => true, 'html' => $html, 'branch_id' => $branch_id,'output'=>$output,'buttonflag'=>$buttonflag,'name'=>$candidateName]);
} catch (Exception $e) {
    echo json_encode(['status' => true, 'html' => '', 'branch_id' => '','output'=>'','name'=>'']);
}
}

public function addSuggestedInetentExample(){
    $intent_id = $this->input->post('intent_id');
    $workspace_id = decode_url_for_zyra($this->input->post('wid'));
    $user_id = decode_url_for_zyra($this->input->post('user_id'));
    $example = trim($this->input->post('example'));
    $examples=$this->common_model->get_common('zyra_intent_examples','*','title',$example,'','');

    if(!empty($examples)){
        echo json_encode(['status' => false]);
    }else{
       $intent_detail=$this->common_model->get_common('zyra_intent','*','id',$intent_id,'','');

       $data = [
        'title' => $example,
        'intent_id' =>$intent_id,
        'cat_id' => $intent_detail->cat_id,
        'sub_cat_id' => $intent_detail->sub_cat_id,
        'user_id' => $user_id,
        'status' => 0,
        'created_on' => date("Y-m-d H:i:s"),
        'updated_on' => date("Y-m-d H:i:s"),
    ];
    $this->common_model->store_data('zyra_intent_examples', $data);
    echo json_encode(['status' => true]); 
}

}

public function updateBranchTeamNotifyMembers() {
    try {
        $branch_id = $this->input->post('branch_id');
        $user_id = decode_url_for_zyra($this->input->post('user_id'));
        $workspace_id = decode_url_for_zyra($this->input->post('wid'));
        $state = $this->input->post('val');
        $array = array('live_chat_notification' => $state);
        $condition = array('branch_id' => $branch_id, 'workspace_id' => $workspace_id);
        $upstatus = $this->common_model->update_data_multiple_condition('zyra_workspace_dialog_branches', $condition, $array);
        if ($upstatus) {
            echo json_encode(['status' => false, 'html' => '']);

        }else{

            echo json_encode(['status' => false, 'html' => '']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => false, 'html' => '']);
    }
        //zyra_workspace_branch_user_emails
}
    // attachment On Off
function attachmentOnOff(){

    $branch_id =  $this->input->post('branch_id');
    $getRes    =  $this->bot_builder_model->updateAttachmentOnOff( $branch_id );
}

function getBranchTeamNotifyMembers(){
  try {
    $branch_id = $this->input->post('branch_id');
    $user_id = decode_url_for_zyra($this->input->post('user_id'));
    $workspace_id = decode_url_for_zyra($this->input->post('wid'));

    $data['userinfo']= $this->common_model->get_common('zyra_user','*','user_id',$user_id,'','');
    $data['branch_id']= $branch_id;
    $info=[
        'branch_id'=>$branch_id,
        'workspace_id'=>$workspace_id
    ];
    $data['team'] = $this->bot_builder_model->external_get_team($info);
    $data['countryCodeLists'] = $this->common_model->get_common_list('zyra_country_code_lists', '*', 'is_default', '0', '', '');
    $data['defaultCountryCodeLists'] = $this->common_model->get_common_list('zyra_country_code_lists', '*', 'is_default', '1', '', '');

    $html = $this->load->view("botbuilder/branch_email_notification", $data, true);
    echo json_encode(['status' => true, 'html' => $html]);

} catch (Exception $e) {
    echo json_encode(['status' => false, 'html' => '']);
}
}


/* Add/Edit Email list on live chat of companies pramanshu */

public function addExternalTeam() {

    $result = '';
    $response = '';



    $team = array(
        'ref_user_id' => $this->session->userdata('userid'),
        'chatBot_id' => $this->session->userdata('chatBot_id'),
        'username' => $this->input->post('username'),
        'jump_in_question' => $this->input->post('jump_in_question'),
        'branch_id'=>$this->input->post('branch_id'),
        'workspace_id'=>decode_url_for_zyra($this->input->post('workSpaceId')),
        'status' => 1,
    );
    $branch_id=$this->input->post('branch_id');
    $workspace_id=$this->input->post('workSpaceId');

    if ($team) {

        /* Code For add */
        if ($this->input->post('oldChatImgname') == '') {
            $team['email_id'] = $this->input->post('email');
            if ($this->input->post('email') != '') {
                $checkTeam = $this->bot_builder_model->external_check_team_email($team);
            } else {
                $checkTeam = false;
            }

            if (!$checkTeam) {

                $team['phone_number'] = $this->input->post('phone_numbers');
                $isd_code = '+1';
                if ( $this->input->post('isd_code_for_notification') ){
                    $isd_code = $this->input->post('isd_code_for_notification');
                }
                $team['isd_code']  = $isd_code;

                $result = $this->common_model->store_data_insert_id('zyra_workspace_branch_user_emails', $team);

                if ($result) {

                        // add chant bot hours
                   $user_data=[
                       'branch_user_id'=>$result,
                       'branch_id'=>$branch_id,
                       'workspace_id'=>$workspace_id,
                   ];

                   $this->updateTimeZoneData($this->input->post(),$user_data);


                   $response = json_encode(array('error' => 0, 'phone_number' => $isd_code."".$team['phone_number'], 'message' => 'Email Added Successfully.', "email" => $team['email_id'], "username" => $team['username'], 'jump_in_question' => $team['jump_in_question'], "id" => $result));
               } else {
                $response = json_encode(array('error' => 1, 'message' => TEAM_SAVED_FAILURE));
            }
        } else {
         $response = json_encode(array('error' => 1, 'message' => $team['email_id'] . " " . TEAM_MEMBER_EXISTS));
     }
 }
 /* Code For add */


 /* Code For update */
 if ($this->input->post('oldChatImgname') == 'update') {

    $data = array();
    $exuserid = $this->input->post('external_user_id');

    $team['external_id'] = $exuserid;
    $checkTeam = $this->bot_builder_model->external_check_team_email($team);
    $data['jump_in_question'] = $this->input->post('jump_in_question');
    if ($checkTeam) {
        if ($this->input->post("email") && $this->input->post("email") != '') {
            $team_data['ref_user_id'] = $this->session->userdata('userid');
            $team_data['email_id'] = $this->input->post('email');

            $checkTeamdata = $this->bot_builder_model->external_check_team_email($team_data);
            if (!empty($checkTeamdata)) {
                echo $response = json_encode(array('error' => 1, 'message' => $team_data['email_id'] . " " . TEAM_MEMBER_EXISTS));
                die;
            }
        }


        $data['username'] = $team['username'];

        $data['phone_number'] = $this->input->post('phone_numbers');
        $isd_code = '+1';
        if ( $this->input->post('isd_code_for_notification') ){
            $isd_code = $this->input->post('isd_code_for_notification');
        }
        $data['isd_code']  = $isd_code;
        
        $result = $this->bot_builder_model->updateData('zyra_workspace_branch_user_emails', $data, array('id' => $exuserid));


        $user_data=[
           'branch_user_id'=>$exuserid,
           'branch_id'=>$branch_id,
           'workspace_id'=>$workspace_id,
       ];

       $this->updateTimeZoneData($this->input->post(),$user_data);


       if ($result) {

        $response = json_encode(array('error' => 0, "phone_number" => $isd_code."".$data['phone_number'], 'message' => 'Email has been updated successfully', "email" => $checkTeam->email_id,  "username" => $team['username'], "id" => $exuserid, 'jump_in_question' => $team['jump_in_question']));
    } else {
        $response = json_encode(array('error' => 1, 'message' => TEAM_SAVED_FAILURE));
    }
} else {
    $response = json_encode(array('error' => 1, 'message' => 'User Not Found'));
}
}
/* Code For update */
} else {
    $response = json_encode(array('error' => 1, 'message' => POST_ERROR));
}
echo $response;
exit();
}


function updateTimeZoneData($post,$user_data) {
    $_POST=$post;
    if ($this->input->post('timezone') != '') {
        if (count($this->input->post('open')) > 0) {

            $this->common_model->delete_data('zyra_workspace_branch_chat_hours', 'branch_user_id', $user_data['branch_user_id']);
            $time_zone_val = $this->input->post('time_zone_val');
            $time_zone_str = substr($time_zone_val, 4, 6);
            foreach ($this->input->post('open') as $key => $val) {
                $data_array2 = array(
                    'user_id' => $this->session->userdata('userid'),
                    'chatBot_id' => $this->session->userdata('chatBot_id'),
                    'open' => $this->input->post('open')[$key],
                    'close' => $this->input->post('close')[$key],
                    'day' => $this->input->post('day')[$key],
                    'off' => (isset($this->input->post('off')[$key]) ? $this->input->post('off')[$key] : ''),
                    'working' => (isset($this->input->post('working')[$key]) ? $this->input->post('working')[$key] : ''),
                    'time_zone' => $this->input->post('timezone'),
                    'time_zone_val' => $time_zone_str,
                    'branch_user_id' => $user_data['branch_user_id'],
                    'branch_id' => $user_data['branch_id'],
                    'workspace_id' => $user_data['workspace_id'],
                );
                    //                print_r($data_array2);
                $this->common_model->store_data('zyra_workspace_branch_chat_hours', $data_array2);
            }
        }
    }
}

public function editExternalTeam() {
    $id = $this->input->post('editid');
    $url = "";
    $emaildata = $this->bot_builder_model->external_get_single_user($id);
    $returnarray=[];
    $savedtimezones = $this->common_model->get_common_list('zyra_workspace_branch_chat_hours', '*', 'branch_user_id', $id, '', '');

    foreach ($savedtimezones as $zones) {
        $returnarray[$zones->day] = $zones;
    }
    $data['details']=$emaildata;
    $data['timezones'] = $returnarray;


    $info=[
        'branch_id'=>$emaildata['branch_id'],
        'workspace_id'=>$emaildata['workspace_id']
    ];
    $data['team'] = $this->bot_builder_model->external_get_team($info);

    $data['countryCodeLists'] = $this->common_model->get_common_list('zyra_country_code_lists', '*', 'is_default', '0', '', '');
    $data['defaultCountryCodeLists'] = $this->common_model->get_common_list('zyra_country_code_lists', '*', 'is_default', '1', '', '');

    $html = $this->load->view("botbuilder/branch_email_notification", $data, true);
    echo json_encode(['status' => true, 'html' => $html,'tme_zone_count'=>count($data['timezones'])]);


    exit();
}

public function deleteTeamExternal() {
    $response = '';
    $deleteTeam = '';
    $team = array(
        'id' => trim($this->input->post('emailnumid')),
        'chatBot_id' => $this->session->userdata('chatBot_id'),
    );
    if ($team) {
            //check if member already exists
        $deleteTeam = $this->bot_builder_model->external_delete_data($team);

        if ($deleteTeam) {
            $response = json_encode(array('error' => 0, 'message' => 'Email deleted successfully.', "id" => $team['id']));
        } else {
            $response = json_encode(array('error' => 1, 'message' => TEAM_DELETE_FAILURE));
        }
    } else {
        $response = json_encode(array('error' => 1, 'message' => POST_DELETE_ERROR));
    }

    echo $response;
    exit();
}


//    function getValidationMsg(){
//        $branch_id=  $this->input->post('branch_id');
//        $val=  $this->input->post('val');
//        if(!empty($branch_id)){
//            
//        }else{
//            
//        }
//        
//    }

function copyBranch() {
    $branch_id = $this->input->post('branch_id');
    $branch_detail = $this->common_model->get_common('zyra_workspace_dialog_branches', '*', 'branch_id', $branch_id, '', '');

    try {
        if (!empty($branch_detail)) {
            $position= $this->bot_builder_model->getLastBranchPosition($branch_detail->workspace_id);
            $this->bot_builder_model->updateBranchPositionplus($branch_detail->position,$branch_detail->workspace_id);
            $new_branch = [
                'branch_name' => "copy " . $branch_detail->branch_name,
                'workspace_id' => $branch_detail->workspace_id,
                'user_id' => $branch_detail->user_id,
                'validation' => $branch_detail->validation,
                'validation_reply' => $branch_detail->validation_reply,
                'status' => $branch_detail->status,
                'created_at' => date('Y-m-d h:i:s'),
                'position' => $branch_detail->position+1,
                'capture_as' => $branch_detail->capture_as,
                'target_branch' => $branch_detail->target_branch,
                'target_branch_type' => $branch_detail->target_branch_type,
                'is_end' => $branch_detail->is_end,
                'updated_at' => date('Y-m-d h:i:s'),
                'team_profile' => $branch_detail->team_profile,
                'team_workspace_members' => $branch_detail->team_workspace_members,
                'live_chat_notification' => $branch_detail->live_chat_notification,
                'is_link_notification'=>$branch_detail->is_link_notification,
                'is_link_team_profile'=>$branch_detail->is_link_team_profile,
                'is_link_team_members'=>$branch_detail->is_link_team_members,
                'transscript_rule'=>$branch_detail->transscript_rule,
                'trans_script_rule_button'=>$branch_detail->trans_script_rule_button,
                'attachment_on_off'=>$branch_detail->attachment_on_off,
                'show_country_code'=>$branch_detail->show_country_code
            ];

            $new_branch_id = $this->common_model->store_data_insert_id('zyra_workspace_dialog_branches', $new_branch);

                // store data zyra_workspace_dialog_branches_ai_rules
            $branch_ai_rules = $this->common_model->get_common_list('zyra_workspace_dialog_branches_ai_rules', '*', 'branch_id', $branch_id, '', '');

            $branch_ai_array = [];
            if (!empty($branch_ai_rules)) {
                foreach ($branch_ai_rules as $branch_ai) {
                    $branch_ai_array[] = array(
                        'intent_id' => $branch_ai->intent_id,
                        'intent_branch_id' => $branch_ai->intent_branch_id,
                        'branch_id' => $new_branch_id,
                        'workspace_id' => $branch_ai->workspace_id,
                        'user_id' => $branch_ai->user_id,
                        'status' => $branch_ai->status,
                        'cat_id' => $branch_ai->cat_id,
                        'sub_cat_id' => $branch_ai->sub_cat_id,
                    );
                }
                /* Save Branch Questions */
                if (!empty($branch_ai_array)) {
                    $this->db->insert_batch('zyra_workspace_dialog_branches_ai_rules', $branch_ai_array);
                }
            }
                // End store data zyra_workspace_dialog_branches_ai_rules
                //zyra_workspace_dialog_branch_questions
            $branch_question = $this->common_model->get_common_list('zyra_workspace_dialog_branch_questions', '*', 'branch_id', $branch_id, '', '');


            if (!empty($branch_question)) {
               $questions = [];
               foreach ($branch_question as $question) {
                $questions[] = array(
                    'question' => $question->question,
                    'branch_id' => $new_branch_id,
                    'workspace_id' => $question->workspace_id,
                    'user_id' => $question->user_id,
                    'status' => $question->status,
                );
                         //array_push($questions, $questions_push);
            }
            /* Save Branch Questions */
            if (!empty($questions)) {

                $this->db->insert_batch('zyra_workspace_dialog_branch_questions', $questions);
            }
        }
                // End store data zyra_workspace_dialog_branch_questions 
                //  zyra_workspace_dialog_branch_buttons
        $branch_button = $this->common_model->get_common_list('zyra_workspace_dialog_branch_buttons', '*', 'branch_id', $branch_id, '', '');
        if (!empty($branch_button)) {
                    //foreach ($details as $data) {
            $buttons = [];
            foreach ($branch_button as $button) {


                $buttons[] = array(
                    'button_title' => $button->button_title,
                    'button_respond_on' => $button->button_respond_on,
                    'button_respond_on_branch' => $button->button_respond_on_branch,
                    'button_respond_on_url' => $button->button_respond_on_url,
                    'button_respond_on_phonecall' => $button->button_respond_on_phonecall,
                    'button_respond_on_sms' => $button->button_respond_on_sms,
                    'button_respond_on_phonecall_country_code' => $button->button_respond_on_phonecall_country_code,
                    'branch_id' => $new_branch_id,
                    'workspace_id' => $button->workspace_id,
                    'user_id' => $button->user_id,
                    'status' => $button->status,
                    'button_phone_call_use_phone_var'=>$button->button_phone_call_use_phone_var,
                    'button_phone_call_use_dynamic_call'=>$button->button_phone_call_use_dynamic_call,
                    'button_phone_call_use_input_method'=>$button->button_phone_call_use_input_method,
                    'button_respond_on_review'=>$button->button_respond_on_review,
                    'button_review_location'=>$button->button_review_location,
                );

            }

            if (!empty($buttons)) {
                $this->db->insert_batch('zyra_workspace_dialog_branch_buttons', $buttons);
                        // echo  $this->db->last_query();
            }

                    //}
        }


                //  zyra_workspace_team_members    
        $teammembers = $this->common_model->get_common_list('zyra_workspace_team_members', '*', 'branch_id', $branch_id, '', '');

        if (!empty($teammembers)) {
            $insert_team = [];
            foreach ($teammembers as $team) {
                $insert_team[] = [
                    'user_id' => $team->user_id,
                    'workspace_id' => $team->workspace_id,
                    'branch_id' => $new_branch_id,
                    'email' => $team->email,
                    'phone' => $team->phone,
                    'created_at' => date('Y-m-d h:i:s'),
                ];

            }
            $this->db->insert_batch('zyra_workspace_team_members', $insert_team);
        }

                // end zyra_workspace_team_members

            // zyra_workspace_question_reponse
        $questionResponses = $this->common_model->get_common_list('zyra_workspace_question_reponse', '*', 'branch_id', $branch_id, '', '');
        ;

            // $question->branch_id in new array of branches

        if (!empty($questionResponses)) {
            $insertQuestionResponse = array();
            foreach ($questionResponses as $question) {

                $insertQuestionResponse[] = array(
                    'question' => $question->question,
                    'branch_id' => $new_branch_id,
                    'workspace_id' => $question->workspace_id,
                    'user_id' => $question->user_id,
                    'status' => $question->status,
                    'created_at' => date("Y-m-d H:i:s")
                );

            }
            if(!empty($insertQuestionResponse)){
                $this->db->insert_batch('zyra_workspace_question_reponse', $insertQuestionResponse);
            }
        }

            // zyra_workspace_branch_user_emails
        $branch_user_emails = $this->common_model->get_common_list('zyra_workspace_branch_user_emails', '*', 'branch_id', $branch_id, '', '');

            // $question->branch_id in new array of branches

        if (!empty($branch_user_emails)) {
                //$insertQuestionResponse = array();
            foreach ($branch_user_emails as $user_emails) {
                $old_bran_user_id = $user_emails->id;
                $email_to_push = array(
                    'ref_user_id' => $user_emails->ref_user_id,
                    'username' => $user_emails->username,
                    'email_id' => $user_emails->email_id,
                    'profile_pic' => $user_emails->profile_pic,
                    'chatBot_id' => $user_emails->chatBot_id,
                    'isd_code' => $user_emails->isd_code,
                    'phone_number' => $user_emails->phone_number,
                    'status' => $user_emails->status,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'jump_in_question' => $user_emails->jump_in_question,
                    'bot_variable_notifocation' => $user_emails->bot_variable_notifocation,
                    'branch_id' => $new_branch_id,
                    'workspace_id' => $user_emails->workspace_id,
                );
                $new_branch_user_id = $this->common_model->store_data_insert_id('zyra_workspace_branch_user_emails', $email_to_push);
                $branch_user_chahours = $this->common_model->get_common_list('zyra_workspace_branch_chat_hours', '*', 'branch_user_id', $old_bran_user_id, '', '');
                if (!empty($branch_user_chahours)) {
                    $chat_bot_hours_data = [];
                    foreach ($branch_user_chahours as $chathours) {
                        $queshpushres_emails = array(
                            'user_id' => $chathours->user_id,
                            'chatBot_id' => $chathours->chatBot_id,
                            'open' => $chathours->open,
                            'close' => $chathours->close,
                            'day' => $chathours->day,
                            'off' => $chathours->off,
                            'time_zone' => $chathours->time_zone,
                            'time_zone_val' => $chathours->time_zone_val,
                            'working' => $chathours->working,
                            'branch_user_id' => $new_branch_user_id,
                            'branch_id' => $new_branch_id,
                            'workspace_id' => $chathours->workspace_id,
                        );
                        array_push($chat_bot_hours_data, $queshpushres_emails);
                    }
                    $this->db->insert_batch('zyra_workspace_branch_chat_hours', $chat_bot_hours_data);
                }
            }
        }


            // zyra_workspace_branch_user_emails
        $zyra_workspace_multiple_choice = $this->common_model->get_common_list('zyra_workspace_multiple_choice', '*', 'branch_id', $branch_id, '', '');

            // $question->branch_id in new array of branches

        if (!empty($zyra_workspace_multiple_choice)) {
                //$insertQuestionResponse = array();
            $zyra_workspace_multiple_choice_array=[];
            foreach ($zyra_workspace_multiple_choice as $multiple_choice) {

                $multiple_choice_to_push = array(
                    'text' => $multiple_choice->text,
                    'user_id' => $multiple_choice->user_id,
                    'branch_id' => $new_branch_id,
                    'workspace_id' => $multiple_choice->workspace_id,
                    'confirmation_button' => $multiple_choice->confirmation_button,
                    'target_branch_id' => $multiple_choice->target_branch_id

                );
                array_push($zyra_workspace_multiple_choice_array, $multiple_choice_to_push); 
            }

            $this->db->insert_batch('zyra_workspace_multiple_choice', $zyra_workspace_multiple_choice_array);
        }

        /* Copy zipdooe rules */
        $zyra_workspace_zipcode_rules = $this->common_model->get_common_list('zyra_workspace_branch_zipcode_rules', '*', 'branch_id', $branch_id, '', '');
        if (!empty($zyra_workspace_zipcode_rules)) {
                //$insertQuestionResponse = array();
            $zyra_workspace_ziprules_array=[];
            foreach ($zyra_workspace_zipcode_rules as $zip_code_rules) {

                $ziprules_to_push = array(
                    'user_id' => $zip_code_rules->user_id,
                    'zipcode' => $zip_code_rules->zipcode,
                    'willing_travel' => $zip_code_rules->willing_travel,
                    'branch_id' => $new_branch_id,
                    'noservice_branch_id' => $zip_code_rules->noservice_branch_id,
                    'workspace_id'=>$zip_code_rules->workspace_id,
                    'receive_chat_notification'=>$zip_code_rules->receive_chat_notification
                );
                array_push($zyra_workspace_ziprules_array, $ziprules_to_push); 
            }

                //$this->db->insert_batch('zyra_workspace_multiple_choice', $zyra_workspace_multiple_choice_array);
            $this->db->insert_batch('zyra_workspace_branch_zipcode_rules', $zyra_workspace_ziprules_array);

        }


        /* End Copy zipdooe rules */





        $response = json_encode(array('status' => 1, 'new_branch_id' => $new_branch_id));
    }else{
      $response = json_encode(array('status' => 0, 'new_branch_id' => ''));  
  }
} catch (Exception $e) {
    $response = json_encode(array('status' => 0, 'new_branch_id' => ''));
}
echo $response;
exit();
        //zyra_workspace_branch_chat_hours
        //zyra_workspace_branch_user_emails
}

function getValidationReply(){
    if (!$this->input->is_ajax_request()) {
        exit('No direct script access allowed');
    }
    $branch_id      = $this->input->post('branch_id');
    $user_id        = $this->input->post('user_id');
    $user_id        = decode_url_for_zyra($user_id);

    $workspace_id   = decode_url_for_zyra($this->input->post('workspace_id'));
    $validation     = $this->input->post('validation');

    $condition = ["branch_id"=>$branch_id,"user_id"=>$user_id,'validation'=>$validation,'workspace_id'=>$workspace_id];
    $data = $this->db->select('validation_reply')->where($condition)->get("zyra_workspace_dialog_branches")->row();
    $resp = [];
    if ( $data  && $data->validation_reply !=''){
        $data = json_decode($data->validation_reply);
        if(!empty($data)){
            foreach($data as $key=>$val){
                $replyData = (array)$val;
                foreach($replyData as $rkey=>$rval){
                    array_push($resp, [$rkey=>$rval]);
                }
            }
        }
    }

    echo json_encode($resp);

}

function getWorkspaceAssign(){
    $user_type = $this->input->post('user_type');
    if ($this->session->userdata('user_type_user') == 'User' && $user_type == 'User') {
        $session_id = $this->session->userdata('userid');

        $data['session_type'] = 'User';
        $template_type = 'template_user';
    } else {
        $session_id = $this->session->userdata('adminid_backend');
        $data['session_type'] = 'Admin';
        $template_type = 'template_admin';
    }
    $workspacelist = $this->bot_builder_model->getWorkspaceCat($session_id, 'Y', 'user');
    $getSelectedBot = $this->common_model->get_common('zyra_workspace_assign', '*', 'user_id', $session_id, '', ''); 
    $botArr = explode(',', $getSelectedBot->workspace_id); 
    if(count($workspacelist)){
        $chkcount = 0;
        $unchkcount = 0;
        foreach ($workspacelist as $key) {
            if(!empty($key->bot_type)) { $ty = $key->bot_type; }else{ $ty = 'WEB'; }
            if(in_array($key->wid, $botArr)){
              if($chkcount==0) { $html = '<h4>Live workspace</h4>'; }
              $ischeck = 'checked';
              $html .= "<li>
              <label class='mt-checkbox mt-checkbox-outline'>". $key->name ." (". $ty .")<input type='checkbox' ". $ischeck . " class='alertLiveWorkspace' id='reseller_bot' value='". $key->wid ."' name='assign_workspace[]' />
              <span></span>
              </label>
              </li>";
              $chkcount++;
          }else{
              if($unchkcount==0) { $html2 = '<h4>Inactive workspace</h4>'; }
              $ischeck = '';
              $html2 .= "<li>
              <label class='mt-checkbox mt-checkbox-outline'>". $key->name ." (". $ty .")<input type='checkbox' ". $ischeck . "  id='reseller_bot' value='". $key->wid ."' name='assign_workspace[]' />
              <span></span>
              </label>
              </li>";
              $unchkcount++;
          } 
      }
  }else{
   $html = 'There is no Workspace, Please add and select.';   
} 
echo json_encode(array('workspace1' => $html, 'workspace2' => $html2  ));
}

function assignLiveWorkspace() {

    try {
        $user_id = $this->session->userdata('adminid_backend');
        $workspace_id = implode(',', $this->input->post('workspace_id'));
        $data_array = array('user_id' => $user_id, 'workspace_id' => $workspace_id); 
        $this->common_model->delete_data('zyra_workspace_assign', 'user_id', $user_id);
        $this->common_model->store_data('zyra_workspace_assign', $data_array);
        echo json_encode(['status' => true, 'message' => 'Record updated successfully.']);
    } catch (Exception $e) {
        echo json_encode(['status' => false, 'message' => 'Error']);
    }
}

function saveBranchPop(){

   $workspace_id = decode_url_for_zyra($this->input->post('workspace_id'));
   $user_id = decode_url_for_zyra($this->input->post('user_id'));
   $position = $this->bot_builder_model->getLastBranchPosition($workspace_id);
   $data_to_push=array(
    'branch_name'=>$this->input->post('title'),
    'workspace_id'=>$workspace_id,
    'user_id'=>$user_id,
    'validation'=>'',
    'status'=>0,
    'created_at'=>date("Y-m-d H:i:s"),
    'position'=>$position+1,
    'capture_as'=>'',
    'target_branch' => '', 
    'is_end' =>'N',
    'team_profile'=>0,
    'team_workspace_members'=>0

); 


   if(!empty($data_to_push)){
      $insert_id=$this->common_model->store_data_insert_id('zyra_workspace_dialog_branches',$data_to_push); 

      if (!empty($insert_id)) {

        $queshpush = array(
            'question' => $this->input->post('question'),
            'branch_id' => $insert_id,
            'workspace_id' => $workspace_id,
            'user_id' => $user_id,
            'status' => 0
        );

        $this->common_model->store_data_insert_id('zyra_workspace_dialog_branch_questions', $queshpush);
    }

    echo json_encode(['status' => 'success', 'insid'=>$insert_id]);
}else{
  echo json_encode(['status' => 'error']);   
}   
}

public function updateLiveStatus() {

    try {
        $user_id = $this->session->userdata('adminid_backend');
        $workspace_id = decode_url_for_zyra($this->input->post('workspace_id'));
        $status = $this->input->post('status');
        $getSelectedBot = $this->common_model->get_common('zyra_workspace_assign', '*', 'user_id', $user_id, '', ''); 
        $workspaceArr = explode(',', $getSelectedBot->workspace_id);
        if($status == 'inactive'){
          $elKey = array_search($workspace_id,$workspaceArr);
          unset($workspaceArr[$elKey]);
      }else if($status == 'live'){ 
          array_push($workspaceArr,$workspace_id);
      }
      $workspaceArr = array_values(array_filter($workspaceArr)); 
      if(count($workspaceArr)){
        $workspace_id = implode(',', $workspaceArr);    
        $data_array = array('user_id' =>$user_id, 'workspace_id' => $workspace_id);
        $this->common_model->delete_data('zyra_workspace_assign', 'user_id', $user_id);
        $this->common_model->store_data('zyra_workspace_assign', $data_array);  
    }else{
        $this->common_model->delete_data('zyra_workspace_assign', 'user_id', $user_id);
    }
    echo json_encode(['status' => true, 'message' => 'Record updated successfully.']);
} catch (Exception $e) {
    echo json_encode(['status' => false, 'message' => 'Error']);
}
}

function addCapturedFiled(){
    $user_id = decode_url_for_zyra($this->input->post('user_id'));
    $workspace_id = decode_url_for_zyra($this->input->post('workspace_id'));
    $key = trim($this->input->post('key'));
            //$slug = strtolower(str_replace(' ', '_', $key));
    $slug = strtolower(preg_replace('/\s+/', '_', $key));
    $condition_check=[
        'slug'=>$slug,
        'status'=>1,
        'user_id'=>$user_id,
        'workspace_id'=>$workspace_id,
    ];
    $countresult=$this->common_model->get_count_by_multiple_condition('zyra_workspace_additional_captured',$condition_check);
    if($countresult>0){
     echo json_encode(['status' => false]); 
 }else{

    $array = array(
        'name' => 'Name',
        'phonenumber' => 'Phone Number',
        'email' => 'Email',
        'zipcode' => 'Zip Code',
        'phone_number' => 'Phone Number',
        'email_id' => 'Phone Number',
        'zip' => 'Phone Number',
        'phone' => 'Phone Number',
    );
    if (array_key_exists($slug, $array)) {
        echo json_encode(['status' => false]); 
        die;
    }
    $result=$this->common_model->get_common('zyra_workspace_additional_captured','*','slug',$slug,'workspace_id',$workspace_id);
    if(!empty($result) && $result->status==0){
        $update=['status'=>1];
        $condition=array(
           'id'=>$result->id,

       );
        $this->common_model->update_data_multiple_condition('zyra_workspace_additional_captured',$condition,$update);   
    }else{

        $data=[
            'title'=>$key,
            'slug'=>$slug,
            'user_id'=>$user_id,
            'workspace_id'=>$workspace_id,
        ];
        $insert_id=$this->common_model->store_data_insert_id('zyra_workspace_additional_captured',$data);
    }
    echo json_encode(['status' => true, 'insert_id' => $insert_id,'slug'=>$slug]); 
}
}

function deleteCapturedFiled(){ 
    $user_id = decode_url_for_zyra($this->input->post('user_id'));
    $workspace_id = decode_url_for_zyra($this->input->post('workspace_id'));
    $key = trim($this->input->post('key'));
    $conditions=[
        'slug'=>$key,
        'user_id'=>$user_id,
        'workspace_id'=>$workspace_id,
    ];
    $update_captured=array('status'=>0);
    $this->common_model->update_data_multiple_condition('zyra_workspace_additional_captured',$conditions,$update_captured);
    $update=array(
        'capture_as'=>''
    );
    $condition=[
        'workspace_id'=>$workspace_id,
        'user_id'=>$user_id,
        'capture_as'=>$key,
    ];
    $this->common_model->update_data_multiple_condition('zyra_workspace_dialog_branches',$condition,$update);
    echo json_encode(['status' => true, 'insert_id' => $insert_id,'slug'=>$slug]);


}
function get_validation_reply(){
    if (!$this->input->is_ajax_request()) {
        exit("Direct access not allowed");
    }


    $workspace_id = decode_url_for_zyra($this->input->post('workspaceId'));
    $branch_id = $this->input->post('branchId');
    $user_id = decode_url_for_zyra($this->input->post('user_id'));
    try{
        if ( $branch_id && $workspace_id && $user_id){
            $validationData   = $this->db->where("user_id",$user_id)
            ->where("workspace_id",$workspace_id)
            ->where("branch_id",$branch_id)
            ->where_in("capture_as",['email','phonenumber'])
            ->get('zyra_workspace_dialog_branches')->row();
            if ( $validationData){

                echo json_encode(['status' => true,'validation'=>$validationData->validation, 'validation_reply' => $validationData->validation_reply]);

            }else{
                echo json_encode(['status' => false]);
            }
        }else{
            echo json_encode(['status' => false]);
        }
    } catch (Exception $ex) {
        echo json_encode(['status' => false]);
    }



}

public function loadStartChatUrl() {
    try {

//            $data['unid'] = $this->input->post('unid');
////            $data['val'] = $this->input->post('val');
//            $data['subtype'] = $this->input->post('subtype');
//            $data['question_id'] = $this->input->post('question_id');
        $data['type'] = 'StartChatUrl';
        $branch_id=$this->input->post('branch_id');

        $data['countryCodeLists'] = $this->common_model->get_common_list('zyra_country_code_lists', '*', 'is_default', '0', '', '');
        $data['defaultCountryCodeLists'] = $this->common_model->get_common_list('zyra_country_code_lists', '*', 'is_default', '1', '', '');

        $data['lists']=$this->common_model->get_common_list('zyra_workspace_branch_url','*','branch_id',$branch_id,'','');
        $data['settings']=$this->common_model->get_common('zyra_workspace_dialog_branches','is_link_notification,is_link_team_profile,is_link_team_members','branch_id',$branch_id,'','');
        $data['emmail_phone_data']=$this->common_model->get_common_list('zyra_workspace_link_team_members','*','branch_id',$branch_id,'','');
        if(empty($data['emmail_phone_data'])){
            $data['emmail_phone_data'][0]=(object)[
                'email'=>'',
                'phone'=>'',
                'isd_code'=>''
            ];
        }

        $intentLists = $this->load->view('botbuilder/branchButtonContent', $data, true);
        echo json_encode(['status' => true, 'html' => $intentLists]);
    } catch (Exception $e) {
        echo json_encode(['status' => false, 'html' => '']);
    }
}


public function saveBranchLink() {
    try {

        $question_arr=json_decode($_POST['questionArr']);

        $params = array();
        parse_str($this->input->post('email_data'), $params);
        $branch_id = $this->input->post('branch_id');

        $workspace_id = decode_url_for_zyra($this->input->post('workspace_id'));
        $user_id = decode_url_for_zyra($this->input->post('created_user_id'));
        $data['question_id'] = $this->input->post('created_user_id');
        $data['type'] = 'StartChatUrl';
        $branch_link_id = $this->input->post('branch_link_id');

        $is_link_notification= $this->input->post('is_link_notification');
        $is_link_team_profile =$this->input->post('is_link_team_profile');
        $is_link_team_members=$this->input->post('is_link_team_members');
        $question_arr_new= array_column($question_arr, 'link');
        $res=$this->bot_builder_model->checkBranchUrlInQuery($workspace_id,$question_arr_new,$branch_id); 

        if(empty($res)){
            if(!empty($question_arr)){
                $html="";
                $unique = uniqid();
                
                $this->common_model->delete_data('zyra_workspace_branch_url','branch_id',$branch_id);
                foreach($question_arr as $quesarr){
                    $arr=[
                        'url'=>$quesarr->link,
                        'branch_id'=>$branch_id,
                        'user_id'=>$user_id,
                        'afterurl'=>$quesarr->afterurl,
                        'auto_popup_time'=>$quesarr->auto_popup_time,
                        'workspace_id'=>$workspace_id,
                    ];
                    $insert_id=$this->common_model->store_data_insert_id('zyra_workspace_branch_url',$arr);
                //<i class="fa fa-pencil" onclick="editBranchLinks(\'' . $unique . '\',\'' . $insert_id . '\')"></i>
                    $html .= '<div class="row branchlinkstart" id="brlinks_' .$unique. '"><div class="col-md-10">
                    <span>' .$quesarr->link. '</span>
                    </div>
                    <div class="col-md-2">
                    <span class="yr-aiEditBtn">
                    <i class="fa fa-trash" title="Delete" onclick="deleteBranchLinks(\'' . $unique . '\',\'' . $insert_id . '\')"></i></span></div>
                    <input type="hidden" class="hidden_branch_links" name="branchLinks[]" value="' .$quesarr->link. '">
                    </div>';
                }
//            if(!empty($arr)){
//            $this->common_model->insertBatch('zyra_workspace_branch_url',$arr);
//            }
            //}



                /************        Udate settings in branch table             **********/

                $setting_array=[
                    'is_link_notification'=>$is_link_notification,
                    'is_link_team_profile'=>$is_link_team_profile,
                    'is_link_team_members'=>$is_link_team_members,
                ];
                $this->common_model->update_data_multiple_condition('zyra_workspace_dialog_branches',['branch_id'=>$branch_id],$setting_array);

                /************        End Udate settings                                     **********/


                /*******     Add email id and phone numbers         ****************/
                if(!empty($params)){
                   $this->common_model->delete_data('zyra_workspace_link_team_members','branch_id',$branch_id);
                   $data_to_insert=[];

                   if($is_link_team_profile!=1){
                       foreach($params['link_data'] as $par){
                           $data_to_insert[]=[
                              'user_id'=>$user_id,
                              'workspace_id'=>$workspace_id,
                              'branch_id'=>$branch_id,
                              'email'=>$par['email'],
                              'isd_code'=>"+".trim($par['country_code']),
                              'phone'=>$par['phone'],
                              'created_at'=>date("Y-m-d h:i:s")

                          ];
                      }

                      if(!empty($data_to_insert)){
                       $this->common_model->insertBatch('zyra_workspace_link_team_members',$data_to_insert);
                   }
               }
           }

           /*******    End  Add email id and phone numbers         ****************/


           echo json_encode(['status' => true, 'html' => $html]);

       }

   }else{
       echo json_encode(['status' => false, 'html' => json_encode($res)]);   
   }





} catch (Exception $e) {
    echo json_encode(['status' => false, 'html' => '']);
}
}

function deleteBranchLink(){
    $branch_link_id = $this->input->post('branch_link_id');
    $branch_id = $this->input->post('branch_id');
    $delete_team=$this->input->post('delete_team');
    $conditions=[
        'id'=>$branch_link_id
    ];
    $this->common_model->delete_data_by_multiple_condition('zyra_workspace_branch_url',$conditions);
    if($delete_team=='1'){
       $this->common_model->delete_data('zyra_workspace_link_team_members','branch_id',$branch_id);
       $setting_array=[
        'is_link_notification'=>0,
        'is_link_team_profile'=>0,
        'is_link_team_members'=>0,
    ];
    $this->common_model->update_data_multiple_condition('zyra_workspace_dialog_branches',['branch_id'=>$branch_id],$setting_array);

}
echo json_encode(['status' => true, 'html' => '']);
}

function uploadIntentExamples(){
    $this->load->helper(array('botbuilder'));
    $uploadFile = '';
    if (!empty($_FILES['import_example_file']['name'])) {
       $uploadFile = time() . preg_replace("/[^a-z0-9\_\.]/i", '_', $_FILES['import_example_file']['name']);
       $uploadpath = "assets/" . $uploadFile;
       try {
        move_uploaded_file($_FILES['import_example_file']['tmp_name'], $uploadpath);
        importIntentExamples($uploadFile);
        echo json_encode(['status' => true, 'message' => 'Import successfully.']);
    } catch (Exception $e) {
        $e->getMessage();
        echo json_encode(['status' => false, 'message' => 'Error']);
    } 
}  
}


function uploadfroalaEditorImage(){
    try {
            // File Route.
        $fileRoute = "assets/wysiwyg-upload/";

        $fieldname = "file";

            // Get filename.
        $filename = explode(".", $_FILES[$fieldname]["name"]);

            // Validate uploaded files.
            // Do not use $_FILES["file"]["type"] as it can be easily forged.
        $finfo = finfo_open(FILEINFO_MIME_TYPE);

            // Get temp file name.
        $tmpName = $_FILES[$fieldname]["tmp_name"];

            // Get mime type.
        $mimeType = finfo_file($finfo, $tmpName);

            // Get extension. You must include fileinfo PHP extension.
        $extension = end($filename);

            // Allowed extensions.
        $allowedExts = array("gif", "jpeg", "jpg", "png", "svg");

            // Allowed mime types.
        $allowedMimeTypes = array("image/gif", "image/jpeg", "image/pjpeg", "image/x-png", "image/png", "image/svg+xml");

            // Validate image.
        if (!in_array(strtolower($mimeType), $allowedMimeTypes) || !in_array(strtolower($extension), $allowedExts)) {
            throw new \Exception("File does not meet the validation.");
        }

            // Generate new random name.
        $name = sha1(microtime()) . "." . $extension;
        $fullNamePath = FCPATH . $fileRoute . $name;

            // Check server protocol and load resources accordingly.
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != "off") {
            $protocol = "https://";
        } else {
            $protocol = "http://";
        }

            // Save file in the uploads folder.
        if(move_uploaded_file($tmpName, $fullNamePath)){
            $response = new \StdClass;
            $response->link = base_url() ."/". $fileRoute . $name;

        }else{
            echo $e->getMessage();
            http_response_code(404);
        }


            // Generate response.

            // Send response.
        echo stripslashes(json_encode($response));
    } catch (Exception $e) {
            // Send error response.
        echo $e->getMessage();
        http_response_code(404);
    }
} 

public function loadMultipleChoiceQuestion() {
    try {

        $branch_id=$this->input->post('branch_id');
        $data['multiple_choice'] = $this->bot_builder_model->multiple_choice_options($branch_id);
        $data['type'] = 'multipleChoiceQuestion';
        $intentLists = $this->load->view('botbuilder/branchButtonContent', $data, true);
        if(!empty($data['multiple_choice'])){
            $target_branch_id=$data['multiple_choice']['target_branch_id'];
        }else{
            $target_branch_id="";
        }

        echo json_encode(['status' => true, 'html' => $intentLists,'target_branch_id'=>$target_branch_id]);
    } catch (Exception $e) {
        echo json_encode(['status' => false, 'html' => '']);
    }
}

function saveMultipleChoiceQuestion(){
 try {  
     $ser=$_REQUEST['ser'];
     $workspace_id = decode_url_for_zyra($this->input->post('workspace_id'));
     $branch_id = $this->input->post('branch_id');
     $user_id = decode_url_for_zyra($this->input->post('user_id'));
     $arr=[];
     foreach($ser as $key=>$value){
      if($value['name']=='branch_options[]'){
          $key2=str_replace('[]', "", $value['name']);
          $arr[$key2][]=$value['value'];
      }else{
          $arr[$value['name']]=$value['value'];
      }


  }

  $condition=['user_id' => $user_id,'branch_id' => $branch_id,'workspace_id' => $workspace_id]; 
  $this->common_model->delete_data_by_multiple_condition('zyra_workspace_multiple_choice',$condition);
  $insert_team_array=[];
  if (!empty($arr)) {
    $target_branch_id=$arr['branchlistmultiplechoice'];
    $confirmation_button=$arr['confirmation_button'];
    foreach ($arr['branch_options'] as $ques) {
        $data = [
            'text' => $ques,
            'user_id' => $user_id,
            'branch_id' => $branch_id,
            'workspace_id' => $workspace_id,
            'confirmation_button' => $confirmation_button,
            'target_branch_id' => $target_branch_id,
        ];
        array_push($insert_team_array, $data);
    }
    $this->common_model->insertBatch('zyra_workspace_multiple_choice', $insert_team_array);
}

$conditions2 = ['user_id' => $user_id,'branch_id' => $branch_id,'workspace_id' => $workspace_id];;
$this->common_model->update_data_multiple_condition('zyra_workspace_dialog_branches', $conditions2, ['attachment_on_off'=>0]);  



$data_multi['multiple_choice_options'] = $this->bot_builder_model->multiple_choice_options($branch_id);
$data_multi['branch_id']=$branch_id;   
$html_multiple_choice = $this->load->view("botbuilder/multiple_choice_option", $data_multi, true);
echo json_encode(['status' => true,'html_multiple_choice'=>$html_multiple_choice]);

} catch (Exception $e) {
    echo json_encode(['status' => false, 'html_multiple_choice' => '']);
} 

}

function deleteMultipleChoiceQuestion(){
 try {  
     $input_id=$this->input->post('id'); 
     $branch_id=$this->input->post('branch_id'); 
     $condition=['id' => $input_id]; 
     $this->common_model->delete_data_by_multiple_condition('zyra_workspace_multiple_choice',$condition);
     $data_multi['multiple_choice_options'] = $this->bot_builder_model->multiple_choice_options($branch_id);
     $data_multi['branch_id']=$branch_id;   
     $html_multiple_choice = $this->load->view("botbuilder/multiple_choice_option", $data_multi, true);
     echo json_encode(['status' => true,'html_multiple_choice'=>$html_multiple_choice ]);

 } catch (Exception $e) {
    echo json_encode(['status' => false]);
}   
}   

function deleteMultipleChoiceQuestionAll(){
   try {  

     $branch_id=$this->input->post('branch_id'); 
     $condition=['branch_id' => $branch_id]; 
     $this->common_model->delete_data_by_multiple_condition('zyra_workspace_multiple_choice',$condition);
     $data_multi['multiple_choice_options'] = $this->bot_builder_model->multiple_choice_options($branch_id);
     $data_multi['branch_id']=$branch_id;   
     $html_multiple_choice = $this->load->view("botbuilder/multiple_choice_option", $data_multi, true);
     echo json_encode(['status' => true,'html_multiple_choice'=>$html_multiple_choice ]);

 } catch (Exception $e) {
    echo json_encode(['status' => false]);
}
}

function updateButtonPosition(){
   if (!empty($buttons)) {
    $insertbuttons = array();
    foreach ($buttons as $button) {
        $respondonbranch = '';
        $respondonurl = '';
        $respondonphone = '';
        $respondsms = '';
        $type = '';
        if ($button['type'] == 'Branch') {

            $respondonbranch = $button['value'];
        }
        if ($button['type'] == 'URL') {

            $respondonurl = $button['value'];
        }
        $countryCode = "+91";
        if ($button['type'] == 'PhoneCall') {


            $to_phone = str_replace('(', '', trim($button['value']));
            $to_phone = str_replace(')', '', $to_phone);
            $to_phone = str_replace(' ', '', $to_phone);
            $to_phone = str_replace('-', '', $to_phone);
            $to_phone = str_replace('+', '', $to_phone);
            $to_phone = substr($to_phone, -10);

            $respondonphone = $to_phone;
            if (isset($button['countryCode']) && $button['countryCode'] !='' ){
                $countryCode = $button['countryCode'];
            }
        }


        if ($button['type'] == 'SMS') {


            $to_phone = str_replace('(', '', trim($button['value']));
            $to_phone = str_replace(')', '', $to_phone);
            $to_phone = str_replace(' ', '', $to_phone);
            $to_phone = str_replace('-', '', $to_phone);
            $to_phone = str_replace('+', '', $to_phone);
            $to_phone = substr($to_phone, -10);

            $respondsms = $to_phone;
            if (isset($button['countryCode']) && $button['countryCode'] !='' ){
                $countryCode = $button['countryCode'];
            }

        }


        $pusharray = array(
            'button_title' => $button['title'],
            'button_respond_on' => $button['type'],
            'button_respond_on_branch' => $respondonbranch,
            'button_respond_on_url' => $respondonurl,
            'button_respond_on_phonecall' => $respondonphone,
            'button_respond_on_sms' => $respondsms,
            'button_respond_on_phonecall_country_code' => $countryCode,
            'branch_id' => $auto_id,
            'workspace_id' => $workspaceid,
            'user_id' => $user_id,
            'status' => 0,
            'button_phone_call_use_phone_var'=>$button['button_phone_call_use_phone_var'],
            'button_phone_call_use_dynamic_call'=>$button['button_phone_call_use_dynamic_call'],
            'button_phone_call_use_input_method'=>$button['button_phone_call_use_input_method'],
            'button_respond_on_review'=>$button['button_respond_on_review'],
            'button_review_location'=>$button['button_review_location'],
        );
        array_push($insertbuttons, $pusharray);
    }
    $this->common_model->insertBatch('zyra_workspace_dialog_branch_buttons', $insertbuttons);

                    // update workspace updated date   
    $this->updateWorkspaceModifiedTime($workspaceid);
}
}


function getReviews() {
    $user_id=decode_url_for_zyra($this->input->post('user_id'));
    $rl = array();
    $result = $this->common_model->get_common('zyra_user', '*', 'user_id', $user_id, '', '');

    if ($result->feature == 'premium') {
        $totalReviewlink = $this->get_multiple_review_location($user_id);
        $review_loca_array = array();
        if (count($totalReviewlink)) {
            $r = 0;
            foreach ($totalReviewlink as $rval) {

                if (!empty($rval['location'])) {
                    if (!in_array($rval['location'], $review_loca_array)) {
                        $review_loca_array[$rval['lid']] = $rval['location'];
                    }

                    $key = $rval['lid'];
                } else {
                    $key = "single";
                }

                $pushtoar = array('link' => $rval['review_link'], 'link_image' => $rval['review_link_image']);
                $rl[$key][] = array($pushtoar);
                $r++;
            }
        }
    }
    if (count($rl)) {
        $reviewfinal = array($rl);
    } else {
        $reviewfinal = $rl;
    }
    if (count($review_loca_array)) {
        $final_review_location = array($review_loca_array);
    } else {
        $final_review_location = $review_loca_array;
    }
    echo json_encode(array('success' => '1', 'review' => $reviewfinal, 'location_review' => $final_review_location,'thumbs_up_msg'=>$result->thumbs_up_msg,'thumbs_down_msg'=>$result->thumbs_down_msg));
}

function get_multiple_review_location($user_id) {
    $DB2 = $this->db;
    $DB2->select('r.*,l.id as lid,l.location');
    $DB2->from('zyra_review_links as r');
    $DB2->join('zyra_user_location_review l', 'r.location_id=l.id', 'left');
    $DB2->where('r.user_id', $user_id);
    $DB2->where('r.review_name_long !="Yelp"');

    $DB2->where("r.review_link!=''");
    $DB2->order_by("r.order_links");
    $query2 = $DB2->get();
        //echo $DB2->last_query();
    $result2 = $query2->result_array();
    return $result2;
}

function loadTranscriptRule(){
    try {

       $user_id=$this->input->post('user_id');
       $branch_id=$this->input->post('branch_id'); 
       $data['type'] = 'TransscriptRule';
       $meta_rule['is_end']="Y";
       $data['transscript_rule'] = $this->input->post('transscript_rule');
       $data['trans_script_rule_button'] = $this->input->post('trans_script_rule_button');;
       $data['completed'] = $this->input->post('chatcompleted');
       $intentLists = $this->load->view('botbuilder/branchButtonContent', $data, true);
       echo json_encode(['status' => true, 'html' => $intentLists]);
   } catch (Exception $e) {
    echo json_encode(['status' => false, 'html' => '']);
}




}

function saveTranscriptRule(){
    try {
        $branch_id=$this->input->post('branch_id');
        $user_id=$this->input->post('user_id');
        $meta_rule['branch_id']=$branch_id;
        $meta_rule['is_end']="Y";
        $meta_rule['trans_script_rule_button']=$this->input->post('trans_script_rule_button');
        $meta_rule['transscript_rule']=$this->input->post('transscript_rule');
        $transcript_rule = $this->load->view("botbuilder/transscript_rule", $meta_rule, true);
        echo json_encode(['status' => true, 'html' => $transcript_rule]);
    } catch (Exception $e) {
        echo json_encode(['status' => false, 'html' => '']);
    }

}


function loadZipcodeRule(){
    try {

       $user_id=decode_url_for_zyra($this->input->post('user_id'));
       $branch_id=$this->input->post('branch_id'); 
       $wid=decode_url_for_zyra($this->input->post('wid')); 

       $data['type'] = 'ZipcodeRule';
       $zipcoderules=$this->bot_builder_model->getBranchZipcodeData($branch_id);
       // get bulk zip code rule
        $zipcoderulesBulk = $this->bot_builder_model->getBulkZipCode($branch_id);
       
        if(empty($zipcoderules)){
        $zipcoderules=[0=>(object)['id'=>'','user_id'=>'','zipcode'=>'','willing_travel'=>'','branch_id'=>'','noservice_branch_id'=>'','lat'=>'','lng'=>'']];
    }
            $excludeValue = $this->common_model->get_common('zyra_workspace_dialog_branches', 'exclude_other_rule', 'branch_id', $this->input->post('branch_id'), '', '');
            $data['zipcode_rules'] = $zipcoderules;
    $branchList = $this->bot_builder_model->getBranchLists($wid, $user_id);
    $data['zipcoderulesBulk'] = $zipcoderulesBulk;
    $data['branch_list']=$branchList;
    $data['all_locations']=json_encode($this->getBranchAlllocations($branch_id));
    $data['excludeValue'] = $excludeValue->exclude_other_rule;
    $intentLists = $this->load->view('botbuilder/branchZipCodeRules', $data, true);
    echo json_encode(['status' => true, 'html' => $intentLists]);
} catch (Exception $e) {
    echo json_encode(['status' => false, 'html' => '']);
}




}

function saveZipCodeRules(){

    $user_id = decode_url_for_zyra($this->input->post('user_id'));
    $branch_id=$this->input->post('branch_id');
    $zipcoderules=$this->input->post('zipcoderules');
    $noservice_branch_id=$this->input->post('noservice_branch_id');
    $workspace_id=decode_url_for_zyra($this->input->post('wid'));
    $data=[];
    $check_data=[];
    foreach($zipcoderules as $ziprules){
        $zipexist=$this->common_model->get_common_list('zipinfo','*','zip',$ziprules['zipcode'],'','');

        if(!empty($zipexist)){
            $data[]=[
                'user_id'=>$user_id,
                'zipcode'=>trim($ziprules['zipcode']),
                'willing_travel'=>$ziprules['willing_travel'],
                'branch_id'=>$branch_id,
                'noservice_branch_id'=>$noservice_branch_id,
                'workspace_id'=>$workspace_id,
                'receive_chat_notification'=>$this->input->post('receive_chat_notification')
            ];
        }else{
            array_push($check_data, $ziprules['zipcode']);
        }
    }
    if(empty($check_data)){
        $this->common_model->delete_data('zyra_workspace_branch_zipcode_rules','branch_id',$branch_id);
        $this->common_model->insertBatch('zyra_workspace_branch_zipcode_rules',$data);
        
        //$this->set_response(['status' => true]);
        echo json_encode(['status'=>true]);
    }else{
      echo json_encode(['status'=>false,'data'=>$check_data]);

  }


}

function getBranchAlllocations($branch_id){
   $i = 0;
   $ziparray = array();
   $result = array();

   $locarray = [];
   $array = $this->bot_builder_model->getBranchZipcodeData($branch_id);
   if (!empty($array)) {
    foreach ($array as $arr) {
        $locarray[$i] = array($arr->zipcode, $arr->lat, $arr->lng, $i + 1, $arr->zipcode, $arr->willing_travel);
        $i++;
    }
}

return $locarray;
}

function deleteZipCodeRules(){
    $user_id = decode_url_for_zyra($this->input->post('user_id'));
    $branch_id=$this->input->post('branch_id');  
    $this->common_model->delete_data('zyra_workspace_branch_zipcode_rules','branch_id',$branch_id);
    echo json_encode(['status'=>true]);
}


    public function saveBulkZipCode()
    {
        $err = 0;
        $message = '';
        $bulkzipid = $this->input->post('bulkzipid') ? $this->input->post('bulkzipid') : '';
        $branch_id = $this->input->post('branch_id') ? $this->input->post('branch_id') : '';
        $excludeValue = $this->input->post('exclude_other_rule') ? $this->input->post('exclude_other_rule') : 0;
        $email = $this->input->post('email') ? $this->input->post('email') : '';
        $bulk_willing_travel_bulk = isset($_POST['bulk_willing_travel_bulk']) ? $this->input->post('bulk_willing_travel_bulk') : 'exact_match';

        if ($email == '') {
            $err++;
            $message = 'Email id not found';
        } elseif ($bulk_willing_travel_bulk == '') {
            $err++;
            $message = 'Send Lead within not found';
        } elseif ($branch_id == '') {
            $err++;
            $message = 'Branch id not found';
}

        if ($err > 0) {
            echo json_encode(array(
                'message' => $message,
                'status'  => false
            ));
            return;
        }

        $allzipcode = array();
        if (isset($_FILES['bulkzipcode'])) {
            $tempFileName = $_FILES['bulkzipcode']['tmp_name'];
            $csv = array_map('str_getcsv', file($tempFileName));
            
            if (count($csv) > 1) {
                foreach ($csv as $key => $value) {
                    array_push($allzipcode, $value[0]);
                }
            }
            array_shift($allzipcode);
        }

        if ($bulkzipid != '') {
            $datatoupdate = array();
            if (empty($allzipcode)) {
                $datatoupdate = array(
                    'send_lead_within' => $bulk_willing_travel_bulk,
                    'email' => $email,
                    'created_at' => $this->input->post('datetime')
                );
            }else{
                $datatoupdate = array(
                    'zipcode' => implode(',', $allzipcode),
                    'send_lead_within' => $bulk_willing_travel_bulk,
                    'email' => $email,
                    'created_at' => $this->input->post('datetime')
                );
            }
            
            $updateStatus = $this->common_model->update_data('zyra_workspace_branch_bulk_zipcode', $datatoupdate, 'id', $bulkzipid, null, null);
            if ($updateStatus) {
                $dataup1 = array(
                    'exclude_other_rule' => $excludeValue
                );
                $this->common_model->update_data('zyra_workspace_dialog_branches', $dataup1, 'branch_id', $branch_id, null, null);
            }
            
            $res = array(
                'message' => $updateStatus ? 'Rule edited successfully.' : 'Something went wrong.',
                'status'  => $updateStatus ? true : false
            );
        }else{
            if (empty($allzipcode)) {
                echo  json_encode(array(
                    'message' => 'File not found',
                    'status'  => false
                ));
            }else{
            $datainsert = array(
                'branch_id' => $branch_id,
                'zipcode' => implode(',', $allzipcode),
                'send_lead_within' => $bulk_willing_travel_bulk,
                'email' => $email,
                    'created_at' => $this->input->post('datetime')
            );

            $insert_id = $this->db->insert('zyra_workspace_branch_bulk_zipcode', $datainsert);
            if ($insert_id) {
                // update branch table
                $dataup = array(
                        'bulk_zipcode' => 1,
                        'exclude_other_rule' => $excludeValue
                );
                $this->common_model->update_data('zyra_workspace_dialog_branches', $dataup, 'branch_id', $branch_id, null, null);

                $res = array(
                        'message' => 'Rule added successfully.',
                    'status'  => true
                );
            } else {
                $res = array(
                        'message' => 'Something went wrong.',
                    'status'  => false
                );
            }
            }
        }
            echo  json_encode($res, true);
        }


    function getBulZipCode()
    {
        if ($this->input->post('branch_id')) {
            $zipcoderulesBulk = $this->bot_builder_model->getBulkZipCode($this->input->post('branch_id'));    
            $excludeValue = $this->common_model->get_common('zyra_workspace_dialog_branches', 'exclude_other_rule', 'branch_id', $this->input->post('branch_id'), '', '');
            $htmldata = '';
            if (!empty($zipcoderulesBulk)) {
                foreach ($zipcoderulesBulk as $key => $value) {
                    // print_r($value);
                    $miles = $value->send_lead_within == "exact_match" ? "Exact match with zip code" : $value->send_lead_within." Miles";
                    $htmldata .= '
                    <li>
                        <small class="showingDate">'.$value->created_at.'</small>
                        <div class="row">
                            <div class="col-md-5">
                                <h5>Zip Code</h5>
                                <a data-toggle="modal" href="#" onclick="getAllBulkData(\''.$value->id.'\',\'zipcodes\')">View All</a>
                            </div>
                            <div class="col-md-5">
                                <h5>Email</h5>
                                <a data-toggle="modal" href="#" onclick="getAllBulkData(\''.$value->id.'\',\'emails\')">View All</a>
                            </div>
                            </div>
                        <div class="yr-branchBtn yr-branchBtn2">
                            <span title="Edit rule" onclick="editBulkData(\''.$value->id.'\')">
                                <i class="fa fa-pencil"></i>
                            </span>
                            <span title="Delete rule" onclick="deleteBulkData(\''.$value->id.'\')">
                                <i class="fa fa-trash"></i>
                            </span>
                        </div>
                    </li>
                    ';
                }
                echo  json_encode(array(
                    'message' => 'Data found',
                    'allData' => $htmldata,
                    'excludeValue' => $excludeValue->exclude_other_rule,
                    'status'  => true
                ));
            }else{
                echo  json_encode(array(
                    'message' => 'Not found',
                    'excludeValue' => $excludeValue->exclude_other_rule,
                    'status'  => false
                ));
            }
        }else{
            echo  json_encode(array(
                'message' => 'Not found',
                'status'  => false
            ));
        }
        
    }

    public function getBulkZipCodedata()
    {
        if ($this->input->post('dataid')) {
            $zipdata = $this->bot_builder_model->getBulkdatabyid($this->input->post('dataid'));
            $excludeValue = $this->common_model->get_common('zyra_workspace_dialog_branches', 'exclude_other_rule', 'branch_id', $this->input->post('branch_id'), '', '');
            if (!empty($zipdata)) {
                echo  json_encode(array(
                    'message' => 'Data found',
                    'zipcodes' => $zipdata[0]->zipcode,
                    'id' => $zipdata[0]->id,
                    'emails' => $zipdata[0]->email,
                    'lead' => $zipdata[0]->send_lead_within,
                    'excludeValue' => $excludeValue->exclude_other_rule,
                    'status'  => true
                ));
            }else{
                echo  json_encode(array(
                    'message' => 'not found',
                    'status'  => false
                ));
            }
        }else{
            echo  json_encode(array(
                'message' => 'not found',
                'status'  => false
            ));
        }
    }
        
    function deleteBulkdata()
    {
        if ($this->input->post('dataid')) {
            $zipdata = $this->common_model->delete_data('zyra_workspace_branch_bulk_zipcode', 'id', $this->input->post('dataid'));

            $zipcoderulesBulk = $this->bot_builder_model->getBulkZipCode($this->input->post('branch_id'));
            if (empty($zipcoderulesBulk)) {
                $branch_id = $this->input->post('branch_id');
                $dataup = array(
                    'bulk_zipcode' => 0,
                    'exclude_other_rule' => 0
                );
                $this->common_model->update_data('zyra_workspace_dialog_branches', $dataup, 'branch_id', $branch_id, null, null);
            }

            echo  json_encode(array(
                'message' => 'Rule deleted successfully.',
                'status'  => true
            ));
        }else{
            echo  json_encode(array(
                'message' => 'Something went wrong.',
                'status'  => false
            ));
}
    }
}
