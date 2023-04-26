<?php
class ControllerCatalogNotification extends Controller
{   
    public function index()
    {   
        $this->load->model('catalog/notification');
        $user_id = $this->session->data['user_id'];
        $push =  $this->model_catalog_notification->getData();
        $array=array(); 
        $rows=array(); 
        $record = 0;
        foreach ($push as $key) {
         $data['subject'] = $key['subject'];
         $data['task'] = $key['task'];
         $data['url'] = 'index.php?route=catalog/task&token='.$this->session->data['token'];
         $rows[] = $data;
         $record++;
        }
        $array['notif'] = $rows;
        $array['count'] = $record;
        $array['result'] = true;
        echo json_encode($array);
    }

}
?>
