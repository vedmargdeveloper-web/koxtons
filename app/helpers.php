<?php

function valid_name( $name ) {
	
	$name = strip_tags($name);

	if( !preg_match("/^[a-zA-Z ]+$/", $name) )
		return false;
	else
		return true;
}



function _app( $app = 'app' ) {
	return 'gift/app/' . $app;
}

function _template( $file = 'index' ) {
	return 'gift/' . $file;
}

function get_extension($filename) {

    $ext = pathinfo( $filename, PATHINFO_EXTENSION );
    return '.'.strtolower($ext);
}

function get_filename($filename) {

    $fname = pathinfo( $filename, PATHINFO_FILENAME );
    return $fname;
}

function uniqueID($length) {
    $keyspace = '01f2of345of678f9abco1234f4def6789hi45o456klmfnop31121fs3t355uvfwxz';
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }

    $uid = random_int(1234, 9999).$str.random_int(1234, 9999);

    return App\User::where('uid', $uid)->first() ? uniqueID( $length ) : $uid;
}

function uniqueEPIN($length) {
    $keyspace = '012345678984789123478345';
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }

    $epin_id = 'bm'.random_int(1234, 9999).$str.random_int(1234, 9999);

    return App\model\Epin::where('epin_id', $epin_id)->first() ? uniqueID( $length ) : $epin_id;
}

function admin_url( $url = '' ) {

	return url('/bm/-/admin/' .$url );
}

function vendor_url( $url = '' ) {

	return url('/0/-/reseller/' .$url );
}

function _admin( $file = 'index' ) {
	return 'gift/admin/' . $file;
}

function _vendor( $file = 'index' ) {
	return 'gift/vendor/' . $file;
}

function admin_app( $app = 'app' ) {
	return 'gift/admin/' . $app;
}

function vendor_app( $app = 'app' ) {
	return 'gift/vendor/' . $app;
}

function public_file( $url = '' ) {
	return 'assets/images/' . $url;
}

function product_file( $url = '' ) {
	return 'assets/products/images/' . $url;
}

function post_file( $url = '' ) {
	return 'assets/posts/images/' . $url;
}

function isAdmin() {
	

	if( Session::has('sessdata') && Session::has('logged_in') && Session::get('logged_in') )
		return true;

	return false;
}

function list_child_item( $list ) {
 
    if( $list ) {
        echo '<ol class="dd-list">';
        foreach( $list as $li ) {
            $type = isset( $li->type ) ? 'data-type="'.$li->type.'"' : '';
            $url = isset( $li->url ) ? 'data-url="'.$li->url.'"' : '';
            $name = isset( $li->name ) ? 'data-name="'.$li->name.'"' : '';
            $id = isset( $li->id ) ? 'data-id="'.$li->id.'"' : '';
            $slug = isset( $li->slug ) ? 'data-slug="'.$li->slug.'"' : '';

            echo '<li class="dd-item" '. $type . ' ' . $url . ' ' . $name . ' ' . $id . ' ' . $slug . '>';
            if( isset( $li->name ) )
                echo '<div class="dd-handle">' . ucfirst($li->name) . '</div>';
            elseif( isset( $li->slug ) )
                echo '<div class="dd-handle">' . str_replace('-', ' ', ucfirst($li->slug)) . '</div>';

            if( isset( $li->children ) )
              list_child_item( $li->children );

            echo '</li>';
        }
        echo '</ol>';
    }
}


function nav_items( $list ) { ?>

	<div class="dropdown-menu">
 
    <?php if( $list ) { ?>

    	<?php foreach( $list as $li ) { ?>
    		<div class="nav-column">
    			<span class="parent">
    				<?php if( isset( $li->slug ) ) : ?>
    					<a href="<?php echo url('/'.$li->slug); ?>">
    						<?php echo isset( $li->name ) ? ucfirst($li->name) : ''; ?>
    					</a>
    				<?php endif; ?>
    			</span>
	    		<ul class="column-1">
	    		<?php if( isset( $li->children, $li->slug ) ) 
	    				list_items( $li->children, $li->slug ); ?>
	            </ul>
	        </div>
        <?php }
    }
}

function list_items( $list, $parent_slug ) {

	if( $list ) {
    	foreach( $list as $li ) { ?>
    		<li class="children">
    			<?php if( isset($li->slug) ) : ?>
    				<a href="<?php echo url('/'.$parent_slug.'/'.$li->slug); ?>">
    					<?php echo isset($li->name) ? ucfirst($li->name) : ''; ?>
    				</a>
    			<?php endif; ?>
    		</li>
<?php  	}
    }
}

function valid_email( $email ) {

	$email = strip_tags($email);

	if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) )
		return FALSE;
	else
		return TRUE;
}

function valid_category( $name ) {
	$name = strip_tags($name);
	if( !preg_match('/^[a-zA-Z0-9 ]+$/', $name) )
		return FALSE;
	else
		return TRUE;
}

function thumb( $filename, $width = '', $height = '' ) {

	$file = pathinfo( $filename, PATHINFO_FILENAME );
	$ext = pathinfo( $filename, PATHINFO_EXTENSION );

	return $file = $file . '-' . $width . 'x' . $height . '.' . $ext;
}


function aasort (&$array, $key) {
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array = $ret;
}


function slug( $string ) {

	$string = strip_tags($string);
	$spcl_char = '<_$>?|(#@/):,.`~^&_-"!\%=+';
	$string = trim($string, $spcl_char);
	$string = trim($string, "'");
	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	$string = trim($string, '-');
	$string = trim(preg_replace("![^a-z0-9]+!i", "-", $string), "'");
	$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	$string = preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
	$string = trim($string, '-');
	return strtolower($string);
}


function clean( $string ) {

	$string = strip_tags($string);

	$spcl_char = '<_$>?|(#@/):,.`~^&_-"!\%=+';
	$string = trim($string, $spcl_char);
	$string = trim($string, "'");

	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	$string = trim($string, '-');
	$string = trim(preg_replace("![^a-z0-9]+!i", "-", $string), "'");
	$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	$string = preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
	$string = trim($string, '-');
	return $string;
}

function randomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}

function imageNewName( $file ) {
	$filename = clean( pathinfo($file, PATHINFO_FILENAME) );
	$extension = pathinfo($file, PATHINFO_EXTENSION);
	$randStr = random_str(10);
	$filename .= '-'.$randStr.'.'.$extension;

	return $filename;
}

function get_excerpt( $string, $length = 20 ) {
	return strip_tags( implode(' ', array_slice(explode(' ', $string), 0, $length)) );
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 0, $quantity);
}

function current_url() {
	return (isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ).$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
}

function decode_char( $string ) {
	$string = str_replace('&lt;', '<', $string );
	$string = str_replace('&gt;', '>', $string );

	return $string;
}

function escape_str($string) {
	$string = strip_tags($string);
	$spcl_char = '<_$>?|(#@/):,.`~^&_-"!\%=+';

	$string = trim( $string, $spcl_char);
	$string = trim($string, "'");
	$string = preg_replace('/[^A-Za-z0-9 ]/', ' ', $string);
	$string = strtolower(preg_replace('/ +/', ' ', $string));
	$string = trim($string, '-');

	return $string;
}
function replace_spcl_char( $string ) {

	$string = strip_tags($string);

	$spcl_char = '<_$>?|(#@/):,.`~^&_-"!\%=+';

	$string = trim( $string, $spcl_char);
	$string = trim($string, "'");
	$string = str_replace(' ', '-', $string);
	$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
	$string = strtolower(preg_replace('/-+/', '-', $string));
	$string = trim($string, '-');

	return $string;
}

function valid_number( $number ) {
	if($number==='')
		return false;
	if(!preg_match('/^[0-9]{10}+$/', $number))
		return false;
	else
		return true;
}
function valid_url( $url ) {

	if( !filter_var($url, FILTER_VALIDATE_URL))
		return false;
	else
		return true;
}
function valid_id( $int ) {
	$options = array(
		    'options' => array('min_range' => 1)
		);
	$int = strip_tags($int);

	if($int === 0 || $int == 0)
		return FALSE;
	if($int === '' || $int == '')
		return FALSE;
	if( !preg_match('/^[0-9]+$/', $int) )
		return FALSE;
	if ( filter_var( $int, FILTER_VALIDATE_INT, $options) === FALSE)
			return FALSE;
	else
		return TRUE;
}

function search_arr($assign, $row) {

	$var = false;
	foreach($assign as $as) {
		if(in_array($row['id'], $as)) {
			return true;
		}
		else
			$var = false;
	}

	return $var;
}

function send_forgot_password_mail( $array ) {

	$header = "MIME-Version: 1.0" . "\r\n";
	$header .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$header .= "From: Reset password ".$array['from'];
	$to = $array['email'];

	$subject = 'Reset your password';
	$message = '<div style="border-radius:5px;padding:10px;"><p style="text-align:center;">';
	$message .= '<img src="'. url('/') .'/public/trippoo/img/trippoo-logo.png"/></p>';
	$message .= '<h2>Reset you password</h2><p>Click on the link below to reset your password</p>';
	$message .= '<h2 style="text-align:center;padding:5px;background-color:#F8F8F8;color:#1b77c6;">';
	$message .= '<a style="text-decoration:none;" href="'. url('/') .'/auth/verify/0/'.urlencode(base64_encode($array['email'])).'?code='.$array['code'].'&action=reset_pswd&id='.$array['hash'].'&auth_m=email_medium&status=false">Reset Password</a></h2>';	
	$message .= '<h3>Need help? mail- '.$array['help'].'</h3></div>';
	
	return mail($to, $subject, $message, $header);
}

/*function encrypt($plainText,$key)
{
  $encryptionMethod = "AES-128-CBC";
  $secretKey = hextobin(md5($key));
  $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
  $encryptedText = openssl_encrypt($plainText, $encryptionMethod, $secretKey, OPENSSL_RAW_DATA, $initVector);
  return bin2hex($encryptedText);

}
function decrypt($encryptedText,$key)
{
  $encryptionMethod   = "AES-128-CBC";
  $secretKey    = hextobin(md5($key));
  $initVector     =  pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
  $encryptedText    = hextobin($encryptedText);
  $decryptedText    =  openssl_decrypt($encryptedText, $encryptionMethod, $secretKey, OPENSSL_RAW_DATA, $initVector);
  return $decryptedText;
}

function pkcs5_pad ($plainText, $blockSize)
{
    $pad = $blockSize - (strlen($plainText) % $blockSize);
    return $plainText . str_repeat(chr($pad), $pad);
}
function hextobin($hexString) 
{ 
      $length = strlen($hexString); 
      $binString="";   
      $count=0; 
      while($count<$length) 
      {       
          $subString =substr($hexString,$count,2);           
          $packedString = pack("H*",$subString); 
          if ($count==0)
          {
            $binString=$packedString;
          } 
                
          else 
          {
            $binString.=$packedString;
          } 
                
          $count+=2; 
      } 
      return $binString; 
}*/


function list_tree( $users ) {
	$c = 0;

    if( $users && count( $users ) > 0 ) {

        foreach( $users as $key => $user ) {

            $c++; $left = $right = '';

            if( $user->side === 'left' )
                $left = $user;

            if( $user->side === 'right' )
                $right = $user;

            if( $c == 2 ) { ?>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 text-center user-tree-row">
                        <?php if( $left ) { ?>
                            <div class="user-image">
                                <img class="img-circle" src="http://placehold.it/50x50">
                                <div class="user-details-box">
                                    <div class="box-inner">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Name</th>
                                                    <td><?php echo ucwords($left->first_name.' '.$left->last_name); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Username</th>
                                                    <td><?php echo strtoupper($left->username); ?></td>
                                                </tr>

                                                <?php if( $left->userdetail && count( $left->userdetail ) > 0 ) { ?>

                                                    <tr>
                                                        <th>Gender</th>
                                                        <td><?php echo ucfirst( $left->userdetail[0]->gender ); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Address</th>
                                                        <td><?php echo ucfirst( $left->userdetail[0]->address.', '.$left->userdetail[0]->landmark ); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>City</th>
                                                        <td><?php echo App\model\City::where('id', $left->userdetail[0]->city)->value('name'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>State</th>
                                                        <td><?php echo App\model\State::where('id', $left->userdetail[0]->state)->value('name'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>County</th>
                                                        <td><?php echo App\model\Country::where('id', $left->userdetail[0]->country)->value('name'); ?></td>
                                                    </tr>
                                                    <tr>
                                                            <th>Contact No.</th>
                                                            <td><?php echo $left->userdetail[0]->phonecode.'-'.$left->userdetail[0]->mobile; ?></td>
                                                        </tr>

                                                <?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="user-name">
                                <span><?php echo strtoupper($left->username); ?></span>
                            </div>

                            <div class="underline">
                                <span class="pull-left">Left</span>
                                <span class="pull-right">Right</span>
                            </div>
                            <?php $users = App\User::with('userdetail')->where('ref_id', $left->username)->get(); ?>
                            <?php list_tree( $users ); ?>

                        <?php } else { ?>
                            <a href="<?php echo route('member.create', 'create?side=left'); ?>">Add</a>
                        <?php } ?>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 text-center user-tree-row">
                        <?php if( $right ) { ?>
                            <div class="user-image">
                                <img class="img-circle" src="http://placehold.it/50x50">
                                <div class="user-details-box">
                                    <div class="box-inner">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Name</th>
                                                    <td><?php echo ucwords($right->first_name.' '.$right->last_name); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Username</th>
                                                    <td><?php echo strtoupper($right->username); ?></td>
                                                </tr>
                                                
                                                <?php if( $right->userdetail && count( $right->userdetail ) > 0 ) { ?>

                                                    <tr>
                                                        <th>Gender</th>
                                                        <td><?php echo ucfirst( $right->userdetail[0]->gender ); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Address</th>
                                                        <td><?php echo ucfirst($right->userdetail[0]->address.', '.$right->userdetail[0]->landmark); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>City</th>
                                                        <td><?php echo App\model\City::where('id', $right->userdetail[0]->city)->value('name'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>State</th>
                                                        <td><?php echo App\model\State::where('id', $right->userdetail[0]->state)->value('name'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>County</th>
                                                        <td><?php echo App\model\Country::where('id', $right->userdetail[0]->country)->value('name'); ?></td>
                                                    </tr>
                                                    <tr>
                                                            <th>Contact No.</th>
                                                            <td><?php echo $right->userdetail[0]->phonecode.'-'.$right->userdetail[0]->mobile; ?></td>
                                                        </tr>
                                                
                                                <?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="user-name">
                                <span><?php echo strtoupper($right->username); ?></span>
                            </div>


                            <div class="underline">
                                <span class="pull-left">Left</span>
                                <span class="pull-right">Right</span>
                            </div>

                            <?php $users = App\User::with('userdetail')->where('ref_id', $right->username)->get(); ?>
                            <?php list_tree( $users ); ?>

                        <?php } else { ?>
                            <a href="<?php echo route('member.create', 'create?side=right'); ?>">Add</a>
                        <?php } ?>
                    </div>
                </div>

                <?php $c = 0; ?>

            <?php } else {

                	if( count( $users ) < 2 ) { ?>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 text-center user-tree-row">
	                        <?php if( $left ) { ?>
	                            <div class="user-image">
	                                <img class="img-circle" src="http://placehold.it/50x50">
                                    <div class="user-details-box">
                                        <div class="box-inner">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th>Name</th>
                                                        <td><?php echo ucwords($left->first_name.' '.$left->last_name); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Username</th>
                                                        <td><?php echo strtoupper($left->username); ?></td>
                                                    </tr>

                                                    <?php if( $left->userdetail && count( $left->userdetail ) > 0 ) { ?>

                                                        <tr>
                                                            <th>Gender</th>
                                                            <td><?php echo ucfirst( $left->userdetail[0]->gender ); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Address</th>
                                                            <td><?php echo ucfirst( $left->userdetail[0]->address.', '.$left->userdetail[0]->landmark ); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>City</th>
                                                            <td><?php echo App\model\City::where('id', $left->userdetail[0]->city)->value('name'); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>State</th>
                                                            <td><?php echo App\model\State::where('id', $left->userdetail[0]->state)->value('name'); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>County</th>
                                                            <td><?php echo App\model\Country::where('id', $left->userdetail[0]->country)->value('name'); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Contact No.</th>
                                                            <td><?php echo $left->userdetail[0]->phonecode.'-'.$left->userdetail[0]->mobile; ?></td>
                                                        </tr>

                                                    <?php } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
	                            </div>
	                            <div class="user-name">
	                                <span><?php echo strtoupper($left->username); ?></span>
	                            </div>

	                            

	                            <div class="underline">
	                                <span class="pull-left">Left</span>
	                                <span class="pull-right">Right</span>
	                            </div>
	                            <?php $users = App\User::with('userdetail')->where('ref_id', $left->username)->get(); ?>
	                            <?php list_tree( $users ); ?>

	                        <?php } else { ?>
	                            <a href="<?php echo route('member.create', 'create?side=left'); ?>">Add</a>
	                        <?php } ?>
	                    </div>

	                    <div class="col-lg-6 col-md-6 col-sm-6 text-center user-tree-row">
	                        <?php if( $right ) { ?>
	                            <div class="user-image">
	                                <img class="img-circle" src="http://placehold.it/50x50">
                                    <div class="user-details-box">
                                        <div class="box-inner">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th>Name</th>
                                                        <td><?php echo ucwords($right->first_name.' '.$right->last_name); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Username</th>
                                                        <td><?php echo strtoupper($right->username); ?></td>
                                                    </tr>
                                                    
                                                    <?php if( $right->userdetail && count( $right->userdetail ) > 0 ) { ?>

                                                        <tr>
                                                            <th>Gender</th>
                                                            <td><?php echo ucfirst( $right->userdetail[0]->gender ); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Address</th>
                                                            <td><?php echo ucfirst($right->userdetail[0]->address.', '.$right->userdetail[0]->landmark); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>City</th>
                                                            <td><?php echo App\model\City::where('id', $right->userdetail[0]->city)->value('name'); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>State</th>
                                                            <td><?php echo App\model\State::where('id', $right->userdetail[0]->state)->value('name'); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>County</th>
                                                            <td><?php echo App\model\Country::where('id', $right->userdetail[0]->country)->value('name'); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Contact No.</th>
                                                            <td><?php echo $right->userdetail[0]->phonecode.'-'.$right->userdetail[0]->mobile; ?></td>
                                                        </tr>
                                                    
                                                    <?php } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
	                            </div>
	                            <div class="user-name">
	                                <span><?php echo strtoupper($right->username); ?></span>
	                            </div>

	                            

	                            <div class="underline">
	                                <span class="pull-left">Left</span>
	                                <span class="pull-right">Right</span>
	                            </div>
                            <?php $users = App\User::with('userdetail')->where('ref_id', $right->username)->get(); ?>
                            <?php list_tree( $users ); ?>

	                        <?php } else { ?>
	                            <a href="<?php echo route('member.create', 'create?side=right'); ?>">Add</a>
	                        <?php } ?>
	                    </div>
                    </div>
            <?php }

        	}
     	}
	}
    else { ?>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 text-center user-tree-row">
                <a href="{{ route('member.create', 'create?side=left') }}">Add</a>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 text-center user-tree-row">
                <a href="{{ route('member.create', 'create?side=right') }}">Add</a>
            </div>
        </div>
    <?php }
}



function list_users( $users, $c ) {
    foreach( $users as $key => $user ) { ?>
        <tr>
            <td><?php echo ++$c; ?></td>
            <td><?php echo strtoupper($user->ref_id); ?></td>
            <td><?php echo ucfirst( App\model\Level::where('user_id', $user->id)->value('level') ); ?></td>
            <td><?php echo strtoupper($user->username); ?></td>
            <td><?php echo ucwords($user->first_name.' '.$user->last_name); ?></td>
            <td><?php echo $user->email; ?></td>
            <td><?php echo $user->created_at->format('d M Y'); ?></td>
            <td>
                <a class="action" href="<?php echo route('member.view', $user->id); ?>"><span class="fas fa-eye"></span></a>
                <a class="action" href="<?php echo route('member.users', $user->id); ?>"><span class="fas fa-users"></span></a>
            </td>
        </tr>
        <?php
            $users = App\User::where('ref_id', $user->username)->get();
            if( $users && count( $users ) > 0 ) {
                list_users( $users, $c );
            }
        ?>
<?php
    }
    return $c;
}


function weekly_users( $users, $c ) {
    foreach( $users as $key => $user ) { ?>
        <tr>
            <td><?php echo ++$c; ?></td>
            <td><?php echo strtoupper($user->ref_id); ?></td>
            <td><?php echo ucfirst( App\model\Level::where('user_id', $user->id)->value('level') ); ?></td>
            <td><?php echo strtoupper($user->username); ?></td>
            <td><?php echo ucwords($user->first_name.' '.$user->last_name); ?></td>
            <td><?php echo $user->email; ?></td>
            <td><?php echo $user->created_at->format('d M Y'); ?></td>
            <td>
                <a class="action" href="<?php echo route('member.view', $user->id); ?>"><span class="fas fa-eye"></span></a>
                <a class="action" href="<?php echo route('member.edit', $user->id); ?>"><span class="fas fa-edit"></span></a>
                <a class="action" href="<?php echo route('member.users', $user->id); ?>"><span class="fas fa-users"></span></a>
            </td>
        </tr>
        <?php
            $users = App\User::where('ref_id', $user->username)->get();
            if( $users && count( $users ) > 0 ) {
                list_users( $users, $c );
            }
        ?>
<?php
    }
    return $c;
}



function list_wallet_amount( $users, $c, $wallet_id = '' ) {
    foreach( $users as $key => $user ) { ?>
        <?php $wall = App\model\WalletRelation::where(['wallet_id' => $wallet_id])->first(); ?>
        <tr>
            <td><?php echo ++$c; ?></td>
            <td><?php echo strtoupper($user->ref_id); ?></td>
            <td><?php echo ucfirst( $wall ? $wall->level : '' ); ?></td>
            <td><?php echo strtoupper($user->username); ?></td>
            <td><?php echo ucwords($user->first_name.' '.$user->last_name); ?></td>
            <td><?php echo $wall ? $wall->amount : 0; ?></td>
            <td><?php echo $user->created_at->format('d M Y'); ?></td>
            
        </tr>
        <?php
            $users = App\User::where('ref_id', $user->username)->get();
            if( $users && count( $users ) > 0 ) {
                list_wallet_amount( $users, $c, $wallet_id );
            }
        ?>
<?php
    }
    return $c;
}


function get_users( $users ) {

    $data = [];
    foreach( $users as $key => $user ) {            
            $data[] = $user;
            $users = App\User::where('ref_id', $user->username)->get();
            if( $users && count( $users ) > 0 ) {

                $data = array_merge( $data, get_users( $users ) );
            }
    }

    return $data;
}

function generate_username() {

    $username = App\User::where('username', '!=', null)->orderby('username', 'DESC')->limit(1)->value('username');
    $username_id = $username ? (int) filter_var($username, FILTER_SANITIZE_NUMBER_INT) + 1 : 1000;

    $name = 'bm'.$username_id;

    if( App\User::where('username', $name)->first() )
        generate_username();

    return strtolower($name);
}


?>