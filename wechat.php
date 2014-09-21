<?php
/*
Plugin Name: WeChat (连接微信)
Author: smyx
Author URI: http://www.smyx.net/
Plugin URI: http://www.smyx.net/wechat.html
Description: This plugin can achieve search Wordpress post, custom keywords, message records and data analyze. (使用微信/易信/新浪微博私信搜索Wordpress文章，关键字自定义回复，消息记录和数据分析，微信服务号或者易信支持自定义菜单。周边相关搜索和有道中英文互译等。)
Version: 0.5
*/

if (!function_exists('installed_zend')) {
	function installed_zend() {
		if (version_compare(PHP_VERSION, '5.5', '>=')) {
			$zend_install_tips = __('Sorry, you cannot use this paid plugin, ZEND is not support for php 5.5.x or above.', 'wechat');
		} else {
			$zend_loader_enabled = function_exists('zend_loader_enabled');
			if ($zend_loader_enabled) {
				$zend_loader_version = function_exists('zend_loader_version') ? zend_loader_version() : '';
				if (version_compare($zend_loader_version, '3.3', '>=')) {
					return;
				} else {
					$zend_install_tips = __('Sorry, you cannot use this paid plugin, ZEND version is not up to date, please update to at least 3.3.0<a href="http://www.zend.com/en/products/guard/downloads" target="_blank">View</a>', 'wechat');
				} 
			} else {
				if (version_compare(PHP_VERSION, '5.3', '>=')) {
					$zend_install_tips = __('Sorry, you cannot use this paid plugin, please contact your server company <a href="http://www.zend.com/en/products/guard/downloads" target="_blank">Zend Guard Loader</a>.', 'wechat');
				} else {
					$zend_install_tips = __('Sorry, you cannot use this paid plugin, please contact your server company <a href="http://www.zend.com/en/products/guard/downloads-prev" target="_blank">Zend Optimizer</a>.', 'wechat');
				} 
			}
		}
		return array('error' => $zend_install_tips);
	} 
}

function wp_wechat_init() {
    load_plugin_textdomain( 'wechat', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'wp_wechat_init' );

add_action('admin_menu', 'wp_wechat_add_page');
function wp_wechat_add_page() {
	$weixin_url = plugins_url('wechat');
	if (function_exists('add_menu_page')) {
		add_menu_page(__('WeChat', 'wechat'), __('WeChat', 'wechat'), 'manage_options', 'wechat', 'wp_wechat_do_page', $weixin_url .'/images/small-weixin.gif');
	} 
} 
add_action('plugin_action_links_' . plugin_basename(__FILE__), 'wp_wechat_plugin_actions');
function wp_wechat_plugin_actions ($links) {
    $new_links = array();
    $new_links[] = '<a href="admin.php?page=wechat">' . __('Settings') . '</a>';
    return array_merge($new_links, $links);
}
// 设置 Setting
function wp_wechat_do_page() {
	$weixin_url = plugins_url('wechat');
	$installed_zend = installed_zend();
	if (is_array($installed_zend)) {
		echo '<div class="updated">';
		echo '<p><strong>' . $installed_zend['error'] . '</strong></p>';
		echo '</div>';
	}
?>
<div class="wrap">
  <h2><img src="<?php echo $weixin_url .'/images/icon_weixin.png';?>" /><?php _e('WeChat', 'wechat');?></h2>
  <h3><?php _e('Plugin Summary', 'wechat');?></h3>
  <p><?php _e('Documentation:', 'wechat');?> <a href="http://www.smyx.net/doc/wechat.html" target="_blank">http://www.smyx.net/doc/wechat.html</a></p>
  <p><?php _e('Current Features:', 'wechat');?></p>
  <?php _e('<p>1. Use WeChat/Yinxin/Sina weibo messages to search Wordoress Posts</p><p>2. custom keywords to reply (include text, image + text, custom image + text, music and etc...)</p><p>3. message records (transcripts betweens clients and public account)</p><p>4. Data Analizy ( included message record，keywords，user activities)</p><p>5. WeChat custom menu ( WeChat Service account should apply)</p><p>6. User could use WeChat to publish Weibo ( need <a href="http://www.smyx.net/wp-connect.html" target="_blank">WP Connect</a> plugin )</p><p>7. support automaticly update from Wordpress backend.</p>', 'wechat');?></p>
  <h3><?php _e('only：￥149 RMB or $28 USD Buy Now: <a href="http://www.smyx.net/wechat.html" target="_blank">http://www.smyx.net/wechat.html</a>', 'wechat');?></h3>
  <p><?php _e('<a href="http://www.smyx.net/wp-connect.html" target="_blank">WP Connect Pro</a> Version User could gain 8 Discount，enter your registered domain to get discount details.', 'wechat');?></p>
  <h3><?php _e('"WeChat Public Account" Account Opening Instruction', 'wechat');?></h3>
  <p><?php _e('1、Open <a href="http://mp.weixin.qq.com/" target="_blank">WeChat Public Account</a>, click on "Register".<br />2、Login to your QQ account, provide all your details, please give a nice name for "Account Name" (Notes: This account name cannot be changed after this setting). <br />3、Select"Regular WeChat Public Account"<br />4、After registration, you could view your account number and QR code under "Settings". It is a good way to download this QR image and put on your website.<br />5、Click "Advance Function", Disable "Editor Model" and go to "Developer Model", enable it, then click on "Become Developer", please fill correct URL and Token.', 'wechat');?>
  </p>
</div>
<?php
} 