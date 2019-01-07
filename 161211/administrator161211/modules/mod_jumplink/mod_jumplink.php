<?php
/*
* mod_jumplink  v1.7
* Paul Daniels 
* Jan 2011
* http://www.quadracode.com.au
* Joomla 1.5 friendly jumplink -
* Creates a dropdown box populated with addresses from the Joomla weblinks table;
* Pushing the go button will redirect to that address.
*/

	defined('_JEXEC') or die ('Direct Access is not allowed');
	$allweblinks = intval($params->get('allweblinks',0));
	$golabel = $params->get('buttonname','Go');
	$blank = intval($params->get('firstblank',0));
	$custom = $params->get('firsttext','');
	$separator = $params->get('separator','');
	$image = $params->get('buttonimage','-1');
	$catname = strtolower($params->get('catname','jumplinks'));
	$autodirect = intval($params->get('autodirect',0));
	$target = $params->get('target','parent');
?>

<script type="text/javascript">

	function golink(target)
	{
		var link = document.jlink.add.value;
		switch(target)
		{
			case 'parent':
				window.location=link;
				break;
			case 'newwith':
				window.open(link);
				break;
				
			case 'newwithout':
				window.open(link,'',config='toolbar=no');
				break;
			default:
				alert("oops!!");
		}

	}
	
</script>

<noscript>
	<p>This module requires javascript to operate. Please enable javascript in your browser or use a browser that support it</p>
</noscript>

<?php
		$db = JFactory::getDBO();
		$cat = "lower(jc.title) = '".$catname."' AND ";
		if ($allweblinks == '1')
			$cat = '';
		$order = $params->get('order',0);
		
		switch ($order)
		{
			case 0:
				$orderStr = "ordering";
				break;
			case 1:
				$orderStr = "j.title ASC";
				break;
			case 2:
				$orderStr = "j.title DESC";
		}
		$query = "SELECT j.* FROM #__weblinks j inner join #__categories jc on j.catid = jc.id where $cat  j.published='1' AND jc.published='1' ORDER BY $orderStr";
		$db->setquery($query);
		$rows=$db->loadObjectList();
		error_reporting(E_ERROR); 
		$url = $_SERVER['SERVER_URI'];
	
		echo "<form name='jlink' action='" . $url . "' method='post' >";
		echo "<p>";

			echo "<select name='add' id='add'";
			if ($autodirect == 1) 
				{
					 echo " onChange='this.form.elements";
					 echo "[\"submit\"].click();' >";
				}
			else
			{
				echo " >";
			}		
		
		if ($blank == '1')
			echo "<option value='' />";
		if ($custom != '')
		{
			echo "<option value='' />".$custom;
			if ($separator != '')
				echo "<option value='' >".str_repeat($separator,strlen($custom))."</option>";
		}

		foreach ($rows as $row)
		{
			echo "<option value='" .$row->url. "' > ". $row->title . "</option>";
		}
		echo "</select>";
	   
			if ($autodirect == 1)
			{
				$style="style='visibility:hidden'";
			}
			if ($image !=-1 )
			{
				if ($autodirect ==1)
					echo "<input type='submit' ".$style." id='submit' name='submit' value='".$golabel."' />";
				$image = 'images/stories/'.$image;
				echo "<input type='image' " .$style." src='".$image."' id='submit' name='submit' alt='".$golabel."' />";
			}
			else
			{
				echo "<input type='submit' ".$style." id='submit' name='submit' onclick =\"golink('".$target."'); return false;\" value='".$golabel."' />";
			}

		echo  "</p></form>";
	
 ?>

