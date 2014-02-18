<?php
class GRABO implements networkmodule {
	public function request($request_type, $request_info, $network_ids, $backfill) {

		error_reporting(0);

		global $zone_detail;
		global $display_ad;
		global $request_settings;

		$request_url = $request_type == 'banner' ? 'http://b.grabo.bg/mobile/_nimasystems/footer' :
		'http://b.grabo.bg/mobile/_nimasystems/popup';

		$httpConfig['method']     = 'GET';
		$httpConfig['timeout']    = 1;
		$httpConfig['siteid']     = $network_ids['p_1'];
			
		$http = new Http();
		$http->initialize($httpConfig);

		// temp
		if ($request_type == 'interstitial') {
			if ($request_info['main_device'] == 'IPAD') {
				$zone_detail['zone_width'] = '768';
				$zone_detail['zone_height'] = '1024';
			} else {
				$zone_detail['zone_width'] = '320';
				$zone_detail['zone_height'] = '480';
			}
		} elseif ($request_type == 'banner') {
			if ($request_info['main_device'] == 'IPAD') {
				$zone_detail['zone_width'] = '600';
				$zone_detail['zone_height'] = '50';
			} else {
				$zone_detail['zone_width'] = '320';
				$zone_detail['zone_height'] = '50';
			}
		}

		$http->addParam('zone_type', $request_type);
		$http->addParam('zone_size', $zone_detail['zone_width'] . 'x' . $zone_detail['zone_height']);
		$http->addParam('zone_refresh_time', $zone_detail['zone_refresh']);
		$http->addParam('zone_lastrequest', $zone_detail['zone_lastrequest']);
		$http->addParam('zone_placement_id', $request_info['placement_hash']);

		if ($request_type=='banner' || $request_type=='interstitial'){

			// private vars!
			//$http->addParam('p_carrier'   , $request_info['ip_address']);
			//$http->addParam('p_longtitude'   , $request_info['longitude']);
			//$http->addParam('p_latitude'   , $request_info['latitude']);

			$http->addParam('p_siteid'   , $network_ids['p_1']);
			$http->addParam('affid'   , $network_ids['p_1']);
			$http->addParam('p_user_agent'   , $request_info['user_agent']);
			$http->addParam('p_page_url'   , $request_info['referer']);
			$http->addParam('p_main_device', $request_info['main_device']);
			$http->addParam('p_device_os', $request_info['device_os']);
			$http->addParam('p_iphone_osversion', $request_info['iphone_osversion']);
			//$http->addParam('p_adspace_width', $request_info['adspace_width']);
			//$http->addParam('p_adspace_height', $request_info['adspace_height']);
			$http->addParam('p_channel', $request_info['channel']);
			$http->addParam('p_geo_country', $request_info['geo_country']);
			$http->addParam('p_geo_region', $request_info['geo_region']);
		}
		else {
			return false;
		}

		$http->execute($request_url);

		if ($http->error){
			return false;
		}

		if ($http->result=='' or preg_match("<!-- mKhoj: No advt for this position -->" , $http->result)){
			return false;
		}

		$banner_url = null;
		$html_response = null;

		if ($request_type=='banner') {
			$html_response_ = @json_decode($http->result);

			if (!$html_response_) {
				return false;
			}

			$html_response_ = (array)$html_response_;
				
			$html_response = $html_response_['markup'];
			$banner_url = $html_response_['url'];
				
			if (!$banner_url) {
				return false;
			}
				
			unset($html_response_);
		} else {
			$html_response = $http->result;
		}

		if (!$html_response) {
			return false;
		}
		
		/*
		$metas = array(
				'apple-mobile-web-app-capable' => 'yes',
				'apple-mobile-web-app-status-bar-style' => 'black',
				'viewport' => 'initial-scale=1.0,user-scalable=no,minimum-scale=1.0,maximum-scale=1.0'
		);

		$m = array();

		foreach($metas as $k => $v) {
			$m[] = '<meta name="' . $k . '" content="' . $v . '" />';
			unset($k, $v);
		}

		$m = implode("\n", $m);

		 $http->result = str_replace('<head>', '<head>' . "\n" . $m . "\n", $http->result);
		$http->result = str_replace('href="//', 'href="http://', $http->result);*/

		if ($request_type == 'banner') {

			$s = '320x480';

			if ($request_info['main_device'] == 'IPAD') {
				$s = '1024x768';
			}

			//$tempad['url'] = 'http://b.grabo.bg/mobile/_nimasystems/popup/?affid=18850&zone_size=' . $s;
			$tempad['url'] = $banner_url;
			$tempad['type'] = 'banner';
			$tempad['markup'] = $html_response;
		} else {

			$display_ad['main_type'] = 'display';
			$request_settings['active_campaign_type'] = 'network';
			$request_settings['active_campaign'] = 2;
			$request_settings['network_id'] = 33;

			prepare_ctr();

			if (!isset($display_ad['final_click_url'])) {
				return false;
			}

			$clk_url = $display_ad['final_click_url'] . "&gurl=";

			$html_response = str_replace('?gurl=', '', $html_response);
			$html_response = str_replace('[BASE_URL]', $clk_url, $html_response);
			
			$tempad['type'] = 'banner';
			$tempad['interstitial-type'] = 'html';
			$tempad['markup'] = $html_response; /*'http://b.grabo.bg' . $http->path;*/
		}

		if ($request_type=='banner'){

			if ($tempad['type']=='banner' or $tempad['type']=='text'){
				$ad=array();
				$ad['main_type']='display';
				$ad['type']='markup';
				$ad['click_url']=$tempad['url'];
				$ad['html_markup']=$tempad['markup'];
				$ad['trackingpixel']='';
				$ad['image_url']='';
				$ad['clicktype']='safari';
				$ad['skipoverlay']=0;
				$ad['skippreflight']='yes';
				return $ad;
			}

			else if ($tempad['type']=='rm'){
				$ad=array();
				$ad['main_type']='display';
				$ad['type']='mraid-markup';
				$ad['click_url']=$tempad['url'];
				$ad['html_markup']=$tempad['markup'];
				$ad['trackingpixel']='';
				$ad['image_url']='';
				$ad['clicktype']='safari';
				$ad['skipoverlay']=0;
				$ad['skippreflight']='yes';
				return $ad;
			}

			else {
				return false;
			}

		}

		else if ($request_type=='interstitial'){

			if ($tempad['type']=='banner' or $tempad['type']=='text'){
				$ad=array();
				$ad['main_type']='interstitial';
				$ad['type']='interstitial';
				$ad['animation']='fade-in';
				/* Interstitial */
				$ad['interstitial-orientation']='portrait';
				$ad['interstitial-preload']=1;
				$ad['interstitial-autoclose']=0;
				$ad['interstitial-type']='markup';
				$ad['interstitial-content']=$tempad['markup'];
				$ad['interstitial-skipbutton-show']=1;
				$ad['interstitial-skipbutton-showafter']=3;
				$ad['interstitial-navigation-show']=0;
				$ad['interstitial-navigation-topbar-show']=0;
				$ad['interstitial-navigation-bottombar-show']=0;
				$ad['interstitial-navigation-topbar-custombg']='';
				$ad['interstitial-navigation-bottombar-custombg']='';
				$ad['interstitial-navigation-topbar-titletype']='fixed';
				$ad['interstitial-navigation-topbar-titlecontent']='';
				$ad['interstitial-navigation-bottombar-backbutton']=0;
				$ad['interstitial-navigation-bottombar-forwardbutton']=0;
				$ad['interstitial-navigation-bottombar-reloadbutton']=1;
				$ad['interstitial-navigation-bottombar-externalbutton']=1;
				$ad['interstitial-navigation-bottombar-timer']=0;
				/* Interstitial */
				return $ad;
			}
			else {
				return false;
			}

		}

		else {

			return false;

		}


		/*F:END*/

	}

}

?>