<?php
class NIMA implements networkmodule {
	public function request($request_type, $request_info, $network_ids, $backfill) {
			
		/*F:START*/

		error_reporting(0); /*Catch XML Exceptions*/
			
		global $zone_detail;
			
		$httpConfig['method']     = 'POST';
		$httpConfig['timeout']    = 1;
		$httpConfig['special']     = 'INMOBI';
		$httpConfig['inmobisiteid']     = $network_ids['p_1'];
			
		$http = new Http();
		$http->initialize($httpConfig);
			
		if ($request_type=='banner' or $request_type=='interstitial'){
			$request_url='http://madserve.dev.bgmiracle.com/nimatest.php';
			$http->addParam('mk-siteid'   , $network_ids['p_1']);
			$http->addParam('mk-carrier'   , $request_info['ip_address']);
			$http->addParam('h-user-agent'   , $request_info['user_agent']);
			$http->addParam('mk-version'   , 'pr-SPEC-ATATA-20090521');
			$http->addParam('h-page-url'   , $request_info['referer']);
			$http->addParam('format'   , 'axml');


			if ($request_type=='interstitial'){

				if ($request_info['main_device']=='IPAD'){
					$http->addParam('mk-ad-slot'   , '16');
				}
				else {
					$http->addParam('mk-ad-slot'   , '14');
				}

			}
			else {
				/*Zone Size Identification*/
				if ($zone_detail['zone_width']=='300' && $zone_detail['zone_height']=='250'){
					$http->addParam('mk-ad-slot'   , '10');
				}
				else if ($zone_detail['zone_width']=='728' && $zone_detail['zone_height']=='90'){
					$http->addParam('mk-ad-slot'   , '11');
				}
				else if ($zone_detail['zone_width']=='468' && $zone_detail['zone_height']=='60'){
					$http->addParam('mk-ad-slot'   , '12');
				}
				else if ($zone_detail['zone_width']=='120' && $zone_detail['zone_height']=='600'){
					$http->addParam('mk-ad-slot'   , '13');
				}
				else if ($zone_detail['zone_width']=='320' && $zone_detail['zone_height']=='480'){
					$http->addParam('mk-ad-slot'   , '14');
				}
				else if ($zone_detail['zone_width']=='1024' && $zone_detail['zone_height']=='768'){
					$http->addParam('mk-ad-slot'   , '16');
				}
				else if ($zone_detail['zone_width']=='1280' && $zone_detail['zone_height']=='800'){
					$http->addParam('mk-ad-slot'   , '17');
				}
				else {
				}
				/*END: Zone Size Identification*/
			}


			if (isset($_GET['rt']) && ($_GET['rt']=='iphone_app' or $_GET['rt']=='android_app' or $_GET['rt']=='ipad_app')){
				if (isset($_GET['o'])){
					$http->addParam('u-id'   , $_GET['o']);
				}
				$http->addParam('d-localization'   , 'en_US');
				$http->addParam('d-netType'   , 'WiFi');
			}

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
			$tempad['url'] = 'http://www.nimasystems.com';
			$tempad['type'] = 'banner';
			$tempad['markup'] = (rand(1, 2) == 2 ?
					'<html><body>this is a <b style="color:red">test</b> string</body></html>' :
					'<html><body>HOORAYY!</body></html>'
			);
				
			/*<?xml version="1.0" encoding="UTF-8" ?>
			 <request type="textAd"><htmlString skipoverlaybutton="0"><![CDATA[<html><body>HOORAYY!</body></html>]]></htmlString><clicktype>inapp</clicktype><clickurl><![CDATA[http://madserve.localhost/md.click.php?zone_id=3&h=1a1e8dcabe648ae330b28b919838edac&type=network&campaign_id=1&network_id=32&c=aHR0cDovL3d3dy5uaW1hc3lzdGVtcy5jb20,]]></clickurl><urltype>link</urltype><refresh>30</refresh><scale>no</scale><skippreflight>yes</skippreflight></request>*/
				
			// http://madserve.localhost/md.request.php?sdk=banner&c.mraid=1&o_iosadvidlimit=0&rt=iphone_app&u=Mozilla%2F5.0%20%28iPhone%3B%20CPU%20iPhone%20OS%207_1%20like%20Mac%20OS%20X%29%20AppleWebKit%2F537.51.2%20%28KHTML%2C%20like%20Gecko%29%20Mobile%2F11D5145e&u_wv=Mozilla%2F5.0%20%28iPhone%3B%20CPU%20iPhone%20OS%207_1%20like%20Mac%20OS%20X%29%20AppleWebKit%2F537.51.2%20%28KHTML%2C%20like%20Gecko%29%20Mobile%2F11D5145e&u_br=Mozilla%2F5.0%20%28iPhone%3B%20CPU%20iPhone%20OS%207_1%20like%20Mac%20OS%20X%29%20AppleWebKit%2F537.51.2%20%28KHTML%2C%20like%20Gecko%29%20Version%2Funknown%20Mobile%2F11D5145e%20Safari%2Funknown&o_iosadvid=92FCD837-4F8E-4B58-9158-30E390D08C26&v=4.1.6&s=5cfbb96276738ca82edd04225c3b5c1d&iphone_osversion=7.1&spot_id=
			
			
		} else {
			$tempad['type'] = 'banner';
			$tempad['interstitial-type'] = 'url';
			$tempad['markup'] = (rand(1, 2) == 2 ?
					'<html><body>this is a <b style="color:red">test</b> string</body></html>' :
					'<html><body>HOORAYY!</body></html>'
			);
			$tempad['markup'] = 'http://www.abv.bg';
			
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