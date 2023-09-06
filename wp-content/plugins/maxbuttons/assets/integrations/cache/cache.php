<?php
namespace MaxButtons;
defined('ABSPATH') or die('No direct access permitted');

class MBCache
{
  protected $has_supercache  = false; // supercache seems to replace quite fine, without our help. 
  protected $has_w3tc = false;
  protected $has_wpengine = false;
  protected $has_fastestcache = false;
  protected $has_siteground = false;

  public function __construct()
  {
    add_action('mb/button/save', array($this, 'save_action'));
  }

  public function save_action($button_id)
  {
    $this->checkCaches();
    $this->flushCache();
  }

  /** Checks which cache plugins are active on the moment a flush is needed */
    public function checkCaches()
    {
      if ( function_exists( 'w3tc_pgcache_flush' ) )
        $this->has_w3tc = true;

      if ( function_exists('wp_cache_clean_cache') )
          $this->has_supercache = true;

      if ( class_exists( 'WpeCommon' ) )
          $this->has_wpengine = true;

      global $wp_fastest_cache;
      if ( method_exists( 'WpFastestCache', 'deleteCache' ) && !empty( $wp_fastest_cache ) )
          $this->has_fastestcache = true;

      // SG SuperCacher
      if (function_exists('sg_cachepress_purge_cache')) {
	        $this->has_siteground = true;
      }

    }

    /* Tries to flush cache there were we have issues
    *
    * @param Array $args Argument Array to provide data.
    */
    public function flushCache()
    {
          // important - first check the available cache plugins
          $this->checkCaches();
          wp_cache_flush();

          if ($this->has_supercache)
            $this->removeSuperCache();

          if ($this->has_w3tc)
              $this->removeW3tcCache();

          if ($this->has_wpengine)
              $this->removeWpeCache();

          if ($this->has_siteground)
              $this->removeSiteGround();

          if ($this->has_fastestcache)
              $this->removeFastestCache();

      }

      protected function removeSuperCache()
      {
         global $file_prefix, $supercachedir;
  	     if ( empty( $supercachedir ) && function_exists( 'get_supercache_dir' ) ) {
  	          $supercachedir = get_supercache_dir();
  	     }
  	     wp_cache_clean_cache( $file_prefix );
      }

      protected function removeW3tcCache()
      {
        w3tc_pgcache_flush();
      }

      protected function removeWpeCache()
      {
        if ( method_exists( 'WpeCommon', 'purge_memcached' ) ) {
            \WpeCommon::purge_memcached();
        }
        if ( method_exists( 'WpeCommon', 'clear_maxcdn_cache' ) ) {
            \WpeCommon::clear_maxcdn_cache();
        }
        if ( method_exists( 'WpeCommon', 'purge_varnish_cache' ) ) {
            \WpeCommon::purge_varnish_cache();
        }
      }

      protected function removeFastestCache()
      {
        global $wp_fastest_cache;
        $wp_fastest_cache->deleteCache();
      }

      protected function removeSiteGround()
      {
      		sg_cachepress_purge_cache();
      }

}
$cache = new MBCache();
