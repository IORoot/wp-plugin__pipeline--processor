<?php

namespace ue\import;

class taxonomy
{
    public $taxonomy_type;

    public $taxonomy_term;

    public $taxonomy_slug;

    public $taxonomy_description = '';

    public $result;



    public function __construct()
    {
        return $this;
    }


    public function set_type($taxonomy)
    {
        if ($taxonomy == null || $taxonomy == '') {
            throw new \Exception('No Taxonomy has been specified. Cannot set.');
        }
        $this->taxonomy_type = $taxonomy;
        return $this;
    }


    public function set_term($term)
    {
        if ($term == null || $term == '') {
            throw new \Exception('No Term has been specified. Cannot set.');
        }
        $this->taxonomy_term = $term;
        return $this;
    }


    public function set_desc($description)
    {
        $this->taxonomy_description = $description;
        return $this;
    }


    /**
     * create category
     *
     * @return void
     */
    public function add_term()
    {

        if (term_exists($this->taxonomy_term, $this->taxonomy_type)){
            (new \yt\e)->line('Term already exists : '.$this->taxonomy_term .' in '. $this->taxonomy_type, 2 );
            return $this;
        }

        $this->taxonomy_slug = strtolower(str_replace(' ', '-', $this->taxonomy_term));

        $this->insert();
        
        return $this;
    }




    private function insert()
    {
        (new \yt\e)->line('Insert Term : '.$this->taxonomy_term . ' into '. $this->taxonomy_type, 2 );

        try {
            $this->result = wp_insert_term(
                $this->taxonomy_term,
                $this->taxonomy_type,
                array(
                    'description' => $this->taxonomy_description,
                    'slug' => $this->taxonomy_slug
                )
            );

        

        } catch (\Exception $e) {
            return false;
        }

        return $this;
    }




}
