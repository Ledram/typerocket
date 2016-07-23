<?php

namespace TypeRocket\Http;

class Redirect
{
    public $url;

    /**
     * @param $data
     *
     * @return Redirect $this
     */
    public function with( $data ) {

        if( !empty( $data ) ) {
            $cookie = new Cookie();
            $cookie->setTransient('tr_redirect_data', $data);
        }

        return $this;
    }

    /**
     * @param $fields
     *
     * @return Redirect $this
     */
    public function withFields( $fields ) {
        if( !empty( $fields ) ) {
            $cookie = new Cookie();
            $cookie->setTransient('tr_old_fields', $fields);
        }

        return $this;
    }

    /**
     * Redirect to route or resource
     *
     * @param $dots
     *
     * @return Redirect $this
     */
    public function toRoute( $dots )
    {
        $dots = explode('.', $dots);
        $this->url = esc_url( home_url( implode('/', $dots ) ) );

        return $this;
    }

    /**
     * @param $resource
     * @param $action
     * @param null $item_id
     *
     * @return Redirect $this
     */
    public function toPage($resource, $action, $item_id = null)
    {
        $query = [];
        $query['page'] = $resource . '_' . $action;

        if($item_id) {
            $query['item_id'] = (int) $item_id;
        }

        $this->url = admin_url() . 'admin.php?' . http_build_query($query);

        return $this;
    }

    /**
     * Redirect to URL
     *
     * @param $url
     *
     * @return Redirect $this
     */
    public function toUrl( $url ) {
        $this->url = esc_url($url);

        return $this;
    }

    /**
     * Run the redirect
     */
    public function now() {
        wp_redirect( $this->url );
    }
}