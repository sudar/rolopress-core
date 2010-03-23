<?php
/*
 * Please do not remove author's information.
 * Created by Sachin Khosla
 * URL : http://www.digimantra.com
 * Date : August 17,2009
 *
 * Modifyed by Sudar <http://sudarmuthu.com/rolopress> to make it more comapatible with WordPress API
 */

class twitterImage {
    var $user='';
    var $image='';
    var $displayName='';
    var $url='';
    var $format='json';
    var $requestURL='http://twitter.com/users/show/';
    var $imageNotFound=''; //any generic image/avatar. It will display when the twitter user is invalid
    var $noUser=true;

    function __construct($user, $generic_image = '') {
        $this->user=$user;
        $this->imageNotFound = $generic_image;
        if ($user == '') {
            $this->image = $this->imageNotFound;
        } else {
            $this->__init();
        }
    }

    /*
     * fetches user info from twitter
     * and populates the related vars
     */
    private function __init() {
        $data=json_decode($this->get_data($this->requestURL.$this->user.'.'.$this->format)); //gets the data in json format and decodes it
        if(strlen($data->error)<=0) {
        //check if the twitter profile is valid
            $this->image=$data->profile_image_url;
            $this->displayName=$data->name;
            $this->url=(strlen($data->url)<=0)?'http://twitter.com/'.$this->user:$data->url;
            $this->location=$data->location;
        } else {
            $this->image = $this->imageNotFound;
        }
    }

    /**
     * creates image tag
     *
     * @params
     * passing linked true -- will return an image which will link to the user's url defined on twitter profile
     * passing display true -- will render the image, else return
     */
    function print_profile_image($linked=false,$display=false) {
        $img="<img src='$this->image' border='0' alt='$this->displayName' />";
        $linkedImg="<a href='$this->url' rel='nofollow' title='$this->displayName'>$img</a>";
        if(!$linked && !$display) //the default case
            return $img;

        if($linked && $display)
            echo $linkedImg;

        if($linked && !$display)
            return $linkedImg;

        if($display && !$linked)
            echo $img;
    }

    /**
     * Return the profile image
     * 
     * @return <type>
     */
    function get_profile_image() {
        return $this->image;
    }

    /**
     * gets the data from a URL
     * @param <string> $url
     * @return <string> the reponse content
     */
    private function get_data($url) {
        $response = wp_cache_get($url, 'rolopress');
        if ($response == false) {
            // if it is not present in cache, make the request
            $response = wp_remote_request($url);
            // set the response in cache
            wp_cache_add($url, $response, 'rolopress');
        }

        if (is_a($response, 'WP_Error')) {
            return '';
        } else {
            return $response['body'];
        }
    }
}

/**
 * Helper function
 * 
 * @param <type> $username
 * @param <type> $default
 * @return <type> 
 */
function rolo_get_twitter_profile_image($username, $default) {
    $t = new twitterImage($username, $default); //create instance of the class and pass the username
    return $t->get_profile_image();
}
?>