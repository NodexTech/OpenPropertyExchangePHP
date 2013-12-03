<?php
/*
This software is provided by the copyright holders and contributors "as is" and any express or implied warranties, 
including, but not limited to, the implied warranties of merchantability and fitness for a particular purpose are disclaimed. 
In no event shall the copyright owner or contributors be liable for any direct, indirect, incidental, special, exemplary, 
or consequential damages (including, but not limited to, 
procurement of substitute goods or services; loss of use, data, or profits; or business interruption) 
however caused and on any theory of liability, 
whether in contract, strict liability, or tort (including negligence or otherwise) 
arising in any way out of the use of this software, even if advised of the possibility of such damage.
*/

class ope {
	var $secret;
	var $client_id;
	var $signature;
	var $version='/v1';
	var $url='http://api.openpropertyexchange.co.uk';
	
	function __construct($client_id, $secret) {
		$this->endpoint=$this->url.$this->version;
		$this->client_id=$client_id;
		$this->secret=$secret;
		$this->GenerateSignature();
	}
	function __destruct() {
		
	}
	function GenerateSignature() {
		$this->signature=hash_hmac('sha256', $this->client_id, $this->secret);	
	}
	function add($document) {
		return $this->post($document);
	}
	function insert($document) {
		return $this->post($document);
	}
	function post($document) {
		$document=json_encode($document);
		$url=$this->endpoint.'/properties/'.$this->client_id.'/add';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,
			array(
				'X-CLIENT-ID:'.$this->client_id,
				'X-SIGNATURE:'.$this->signature,
				'Content-Type: application/json',
				'Content-Length: '.strlen($document))
			);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $document);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		$ret = curl_exec($ch);
		curl_close($ch);
		return $ret;
	}
	function update($document) {
		$document=json_encode($document);
		$url=$this->endpoint.'/properties/'.$this->client_id.'/update';
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,
			array(
				'X-CLIENT-ID:'.$this->client_id,
				'X-SIGNATURE:'.$this->signature,
				'Content-Type: application/json',
				'Content-Length: '.strlen($document))
			);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $document);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		$ret = curl_exec($ch);
		curl_close($ch);
		return $ret;
	}
	function delete($document) {
		$document=json_encode($document);
		$url=$this->endpoint.'/properties/'.$this->client_id.'/delete';
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,
			array(
				'X-CLIENT-ID:'.$this->client_id,
				'X-SIGNATURE:'.$this->signature,
				'Content-Type: application/json',
				'Content-Length: '.strlen($document))
			);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $document);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		$ret = curl_exec($ch);
		curl_close($ch);
		return $ret;
	}
	function property($since='') {
		return $this->get('/property',$since);	
	}
	function get($path,$since='') {
		$url=$this->endpoint.$path;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, 
		array(
				'X-CLIENT-ID:'.$this->client_id,
				'X-SIGNATURE:'.$this->signature,
				'Content-Type: application/json'
			)
		);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$ret = curl_exec($ch);
		curl_close($ch);
		return $ret;
	}
	function stats($type='property',$id) {
		$url=$this->endpoint.'/'.$type.'/'.$id;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, 
		array(
				'X-CLIENT-ID:'.$this->client_id,
				'X-SIGNATURE:'.$this->signature,
				'Content-Type: application/json'
			)
		);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$ret = curl_exec($ch);
		curl_close($ch);
		return $ret;
	}
	function schema($id) {
		$url=$this->endpoint.'/schemas/'.$id;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, 
		array(
				'X-CLIENT-ID:'.$this->client_id,
				'X-SIGNATURE:'.$this->signature,
				'Content-Type: application/json'
			)
		);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$ret = curl_exec($ch);
		curl_close($ch);
		return $ret;
	}
}
?>