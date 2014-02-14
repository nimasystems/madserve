<?php
class GRABO implements networkmodule {
	public function request($request_type, $request_info, $network_ids, $backfill) {

		error_reporting(0);
			
		global $zone_detail;
			
		$httpConfig['method']     = 'POST';
		$httpConfig['timeout']    = 1;
		$httpConfig['siteid']     = $network_ids['p_1'];
			
		$http = new Http();
		$http->initialize($httpConfig);

		$http->addParam('zone_type', $request_type);
		$http->addParam('zone_size', $zone_detail['zone_width'] . 'x' . $zone_detail['zone_height']);
		$http->addParam('zone_refresh_time', $zone_detail['zone_refresh']);
		$http->addParam('zone_lastrequest', $zone_detail['zone_lastrequest']);
		$http->addParam('zone_placement_id', $request_info['placement_hash']);
		
		if ($request_type=='banner' or $request_type=='interstitial'){

			// private vars!
			//$http->addParam('p_carrier'   , $request_info['ip_address']);
			//$http->addParam('p_longtitude'   , $request_info['longitude']);
			//$http->addParam('p_latitude'   , $request_info['latitude']);
				
			$http->addParam('p_siteid'   , $network_ids['p_1']);
			$http->addParam('p_user_agent'   , $request_info['user_agent']);
			$http->addParam('p_page_url'   , $request_info['referer']);
			$http->addParam('p_main_device', $request_info['main_device']);
			$http->addParam('p_device_os', $request_info['device_os']);
			$http->addParam('p_iphone_osversion', $request_info['iphone_osversion']);
			$http->addParam('p_adspace_width', $request_info['adspace_width']);
			$http->addParam('p_adspace_height', $request_info['adspace_height']);
			$http->addParam('p_channel', $request_info['channel']);
			$http->addParam('p_geo_country', $request_info['geo_country']);
			$http->addParam('p_geo_region', $request_info['geo_region']);
		}
		else {
			return false;
		}

		/*$http->execute($request_url);

		if ($http->error){
		return false;
		}

		if ($http->result=='' or preg_match("<!-- mKhoj: No advt for this position -->" , $http->result)){
		return false;
		}

		try {
		$xml_response = new SimpleXmlElement($http->result, LIBXML_NOCDATA);
		} catch (Exception $e) {
		// handle the error
		return false;
		}*/

		if ($request_type == 'banner') {
			$tempad['url'] = 'http://b.grabo.bg/?city=&affid=18825&size=300x600';
			$tempad['type'] = 'banner';
			/*$tempad['markup'] = (rand(1, 2) == 2 ?
					'<html><body style="height:100%;background-color:green">this is a <b style="color:red">test</b> string</body></html>' :
					'<html><body style="height:100%;background-color:green">HOORAYY!</body></html>'
			);*/

			$tempad['markup'] = file_get_contents('http://ads.nimasystems.com/data/creative/grabo/banner_hx50.html');

			/*<?xml version="1.0" encoding="UTF-8" ?>
			 <request type="textAd"><htmlString skipoverlaybutton="0"><![CDATA[<html><body>HOORAYY!</body></html>]]></htmlString><clicktype>inapp</clicktype><clickurl><![CDATA[http://madserve.localhost/md.click.php?zone_id=3&h=1a1e8dcabe648ae330b28b919838edac&type=network&campaign_id=1&network_id=32&c=aHR0cDovL3d3dy5uaW1hc3lzdGVtcy5jb20,]]></clickurl><urltype>link</urltype><refresh>30</refresh><scale>no</scale><skippreflight>yes</skippreflight></request>*/

			// http://madserve.localhost/md.request.php?sdk=banner&c.mraid=1&o_iosadvidlimit=0&rt=iphone_app&u=Mozilla%2F5.0%20%28iPhone%3B%20CPU%20iPhone%20OS%207_1%20like%20Mac%20OS%20X%29%20AppleWebKit%2F537.51.2%20%28KHTML%2C%20like%20Gecko%29%20Mobile%2F11D5145e&u_wv=Mozilla%2F5.0%20%28iPhone%3B%20CPU%20iPhone%20OS%207_1%20like%20Mac%20OS%20X%29%20AppleWebKit%2F537.51.2%20%28KHTML%2C%20like%20Gecko%29%20Mobile%2F11D5145e&u_br=Mozilla%2F5.0%20%28iPhone%3B%20CPU%20iPhone%20OS%207_1%20like%20Mac%20OS%20X%29%20AppleWebKit%2F537.51.2%20%28KHTML%2C%20like%20Gecko%29%20Version%2Funknown%20Mobile%2F11D5145e%20Safari%2Funknown&o_iosadvid=92FCD837-4F8E-4B58-9158-30E390D08C26&v=4.1.6&s=5cfbb96276738ca82edd04225c3b5c1d&iphone_osversion=7.1&spot_id=


		} else {
			$tempad['type'] = 'banner';
			$tempad['interstitial-type'] = 'url';
			/*$tempad['markup'] = (rand(1, 2) == 2 ?
					'<html><body style="height:100%;background-color:green">this is a <b style="color:red">test</b> string</body></html>' :
					'<html><body style="height:100%;background-color:green">HOORAYY INTERSTITIAL!</body></html>'
			);*/
			$tempad['markup'] = 'http://b.grabo.bg/?city=&affid=18825&size=300x600';

			/*<?xml version="1.0" encoding="UTF-8" ?>
			 <ad type="interstitial" animation="None"><interstitial preload="0" autoclose="0" type="markup"  orientation="portrait"><markup><![CDATA[<html><body>HOORAYY!</body></html>]]></markup><skipbutton show="1" showafter="0"></skipbutton><navigation show="0"><topbar custombackgroundurl="" show="0" title="fixed" titlecontent=""></topbar><bottombar custombackgroundurl="" show="0" backbutton="0" forwardbutton="0" reloadbutton="0" externalbutton="0" timer="0"></bottombar></navigation></interstitial></ad>*/

			// http://madserve.localhost/md.request.php?sdk=vad&c.mraid=0&o_iosadvidlimit=0&u=Mozilla%2F5.0%20%28iPhone%3B%20CPU%20iPhone%20OS%207_1%20like%20Mac%20OS%20X%29%20AppleWebKit%2F537.51.2%20%28KHTML%2C%20like%20Gecko%29%20Mobile%2F11D5145e&u_wv=Mozilla%2F5.0%20%28iPhone%3B%20CPU%20iPhone%20OS%207_1%20like%20Mac%20OS%20X%29%20AppleWebKit%2F537.51.2%20%28KHTML%2C%20like%20Gecko%29%20Mobile%2F11D5145e&u_br=Mozilla%2F5.0%20%28iPhone%3B%20CPU%20iPhone%20OS%207_1%20like%20Mac%20OS%20X%29%20AppleWebKit%2F537.51.2%20%28KHTML%2C%20like%20Gecko%29%20Version%2Funknown%20Mobile%2F11D5145e%20Safari%2Funknown&v=4.1.6&s=21080a259d6574c7863ca168b47e670a&iphone_osversion=7.1&o_iosadvid=92FCD837-4F8E-4B58-9158-30E390D08C26&rt=iphone_app&t=1391747751.608625&i=10.10.9.56
		}

		/*
		 if (isset($xml_response->Ads->Ad['type'])) {
		$tempad['type']=$xml_response->Ads->Ad['type'];
		} else {$tempad['type']='';
		}

		if (isset($xml_response->Ads->Ad)) {
		$tempad['markup']=$xml_response->Ads->Ad;
		} else {$tempad['markup']='';
		}

		if (isset($xml_response->Ads->Ad->AdURL)) {
		$tempad['url']=$xml_response->Ads->Ad->AdURL;
		} else {$tempad['url']='';
		}

		if ($tempad['url']=='null' or $tempad['url']==''){
		return false;
		}*/

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
				$ad['animation']='None';
				/* Interstitial */
				$ad['interstitial-orientation']='portrait';
				$ad['interstitial-preload']=0;
				$ad['interstitial-autoclose']=0;
				$ad['interstitial-type']=(isset($tempad['interstitial-type']) ? $tempad['interstitial-type'] : 'markup');
				$ad['interstitial-content']=$tempad['markup'];
				$ad['interstitial-skipbutton-show']=1;
				$ad['interstitial-skipbutton-showafter']=0;
				$ad['interstitial-navigation-show']=0;
				$ad['interstitial-navigation-topbar-show']=0;
				$ad['interstitial-navigation-bottombar-show']=0;
				$ad['interstitial-navigation-topbar-custombg']='';
				$ad['interstitial-navigation-bottombar-custombg']='';
				$ad['interstitial-navigation-topbar-titletype']='fixed';
				$ad['interstitial-navigation-topbar-titlecontent']='';
				$ad['interstitial-navigation-bottombar-backbutton']=0;
				$ad['interstitial-navigation-bottombar-forwardbutton']=0;
				$ad['interstitial-navigation-bottombar-reloadbutton']=0;
				$ad['interstitial-navigation-bottombar-externalbutton']=0;
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