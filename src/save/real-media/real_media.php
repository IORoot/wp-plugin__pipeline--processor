<?php

namespace ue\import;

use WP_REST_Request;
use MatthiasWeb\RealMediaLibrary\rest\Service;
use MatthiasWeb\RealMediaLibrary\rest\Attachment;

class realmedia
{

    /**
     * $attachment_id variable
     * 
     * The image ID to put into a folder.
     *
     * @var int
     */
    private $attachment_id;

    /**
     * $folder_slug variable
     *
     * This is the name of the folder you want to put
     * the image into.
     * 
     * @var string
     */
    private $folder_slug;

    /**
     * $rml_menu_id variable
     *
     * This is the returned ID of the folder in 
     * Real Media.
     * 
     * @var int
     */
    private $rml_menu_id;


    /**
     * move_into_RML_folder function
     * 
     * The folder_slug is infact a string match with
     * stripos() (Case insensitive) So, just
     * use the words to match the menu name.
     *
     * @param int $attachment_id
     * @param string $folder_slug
     * @return void
     */
    public function move_into_RML_folder($attachment_id, $folder_slug)
    {

        // Are you using Real-Media-Library plugin?
        if (!defined("RML_NS")) {
            return false;
        }

        if (!is_plugin_active('real-media-library/index.php')) {
            return false;
        }

        if (!$attachment_id || $attachment_id == '' || $attachment_id == null) {
            return false;
        }

        if (!$folder_slug || $folder_slug == '' || $folder_slug == null) {
            return false;
        }

        $this->set_attachment_id($attachment_id);
        $this->set_folder_slug($folder_slug);
        $this->get_RML_folder_id();
        $this->move_image_into_RML_folder();
    }

    //  ┌─────────────────────────────────────────────────────────────────────────┐
    //  │                                                                         │░
    //  │                                                                         │░
    //  │                                 PRIVATE                                 │░
    //  │                                                                         │░
    //  │                                                                         │░
    //  └─────────────────────────────────────────────────────────────────────────┘░
    //   ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░

    private function set_attachment_id($attachment_id)
    {
        $this->attachment_id = $attachment_id;
    }

    private function set_folder_slug($folder_slug)
    {
        $this->folder_slug = $folder_slug;
    }


    private function get_RML_folder_id()
    {
        $rml_service = new Service;

        $request = new WP_REST_Request('GET', '/wp/v2/posts');

        $tree =  $rml_service->routeTree($request);

        $slugs = $tree->get_data();

        foreach ($slugs['slugs']['names'] as $key => $name) {
            if (stripos($name, $this->folder_slug)) {
                $this->rml_menu_id = $slugs['slugs']['slugs'][$key];
            }
        }

        return;
    }




    private function move_image_into_RML_folder()
    {
        if (!$this->rml_menu_id || $this->rml_menu_id == '' || $this->rml_menu_id == null) {
            return;
        }

        if (is_a($this->rml_menu_id, 'WP_Error')) {
            throw new Exception('rml_menu_id WP_ERROR when looking for RML folder :' . json_encode($this->rml_menu_id));
            return false;
        }

        if (is_a($this->attachment_id, 'WP_Error')) {
            throw new Exception('attachment_id WP_ERROR when looking for RML folder :' . json_encode($this->rml_menu_id));
            return false;
        }
        
        $rml_attachment = new Attachment;

        $request = new WP_REST_Request('PUT', '/wp/v2/posts');
    
        $request->set_query_params([
            'ids' => [$this->attachment_id],
            'to' => $this->rml_menu_id
        ]);
    
        try {
            $rml_attachment->routeBulkMove($request);
        } catch (Exception $e) {
            throw new Exception('Exception trying to move into RML Folder. ' . json_encode($this->rml_menu_id));
            return false;
        }
    
        return true;
    }


}