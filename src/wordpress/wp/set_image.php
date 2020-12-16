<?php

namespace ue\wp;

class set_image
{

    /**
     * This is the new file to add to the post
     */
    public $filename;

    /**
     * Post ID to attach the new image to.
     */
    public $id;


    /**
     * This is the resulting ID of the image attachment.
     */
    public $attachment_id;



    public function set_filename($filename)
    {
        $this->filename = $filename;
    }

    
    public function set_id($id)
    {
        $this->id = $id;
    }

    
    public function update_post_thumbnail()
    {
        if (!$this->is_valid()){ return; }

        $this->create_attachment();

        set_post_thumbnail($this->id, $this->attachment_id);

        return $this->attachment_id;
    }

    private function is_valid()
    {
        // are there moustaches?
        if (strpos($this->filename, '{{', ) !== false){ return false; }

        // are there arrows?
        if (strpos($this->filename, '->', ) !== false){ return false; }

        // does file exist?
        if (!file_exists( WP_CONTENT_DIR . '/uploads/' . $this->filename)){ return false; }
        
        return true;

    }
    


    public function create_attachment(){

        // Check the type of file. We'll use this as the 'post_mime_type'.
        $filetype = wp_check_filetype(basename($this->filename), null);
        
        // Get the path to the upload directory.
        $wp_upload_dir = wp_upload_dir();
        
        // Prepare an array of post data for the attachment.
        $attachment = array(
            'guid'           => $wp_upload_dir['url'] . '/' . basename($this->filename),
            'post_mime_type' => $filetype['type'],
            'post_title'     => preg_replace('/\.[^.]+$/', '', basename($this->filename)),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );
        
        $new_file = str_replace(get_site_url() . '/', '', $this->filename);

        // Insert the attachment.
        $this->attachment_id = wp_insert_attachment($attachment, $new_file, $this->id);
        
        // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        
        /**
         * Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
         * - width
         * - height
         * - file
         * Creates thumbnails and intermediate filesizes too.
         */
        $attach_data = wp_generate_attachment_metadata($this->attachment_id, $new_file);


        $updated_data = wp_update_attachment_metadata($this->attachment_id, $attach_data);
    }

}
