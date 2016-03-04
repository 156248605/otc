<?php if (!defined('THINK_PATH')) exit();?><div class="box">
	<p>
	尊敬的用户：<br/>
		&nbsp;&nbsp;<b><?php echo ($data["realname"]); ?></b>,您好！<br/>
		&nbsp;&nbsp;您的<?php echo ($data["productname"]); ?>债权审核未通过，已被退回，请及时处理，谢谢:<br/> 
		&nbsp;&nbsp;退回理由:<?php echo ($data["auditmemo"]); ?><br/>
		&nbsp;&nbsp;请勿直接回复本邮件。<br/>
		&nbsp;&nbsp;感谢您使用<h3><?php echo C('SYSTEM_NAME');?>！</h3><br/>
		&nbsp;&nbsp;此邮件为自动发送，请勿回复！<br/>
	</p>
</div>