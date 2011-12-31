<br/>
<div class="success" id="success_div" style="display:none;"></div>

<!--********************************FILTER BOX************************-->
<div style="text-align:center;padding:10px">
    <div class="button white">
    <form method="get" action="<?php echo base_url();?>manage_accounts/index/<?php echo $filter_account_type;?>/" > 
        <table width="100%" cellspacing="0" cellpadding="0" border="0" id="filter_table">
             
                <tr>
                    <td width="25%">
                        Type
                    </td>

                    <td width="25%" rowspan="2">
                        <input type="submit" name="searchFilter" value="SEARCH" class="button blue" style="float:right;margin-top:5px;margin-right:10px" />
                    </td>
                    
                    <td width="25%" rowspan="2">
                        <a href="#" id="reset" class="button orange" style="float:left;margin-top:5px;">RESET</a>
                    </td>
                
                </tr>
            
                <tr>
                    <td>
                        <select name="filter_enabled" id="filter_enabled" style="width:150px;">
                            <option value="">Select</option>
                            <option value="1" <?php if($filter_enabled == '1'){ echo "selected";}?>>Enabled</option>
                            <option value="0" <?php if($filter_enabled == '0'){ echo "selected";}?>>Disabled</option>
                        </select>
                    </td>
                    
                </tr>
            
        </table>
    </form>
    </div>
</div>
<!--***************** END FILTER BOX ****************************-->
<!--
<div style="float:right;margin-bottom:10px;">
    <form method="post" id="new_account_type_form" action="<?php //echo base_url();?>manage_accounts/new_account">
    <a href="#" style="font-weight:bold;font-size:12px;">Create New</a>
    <select style="width:150px;" class="textfield" name="new_account_type" id="new_account_type">
        <option value="">Select</option>
        <option value="admin">Admin Account</option>
        <option value="customer">Customer Account</option>
    </select>
    </form>
</div>
-->
<table style="border: 1px groove;" width="100%" cellpadding="0" cellspacing="0">
        <tbody>
        <tr>
            <td>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr class="bottom_link">
                        <td height="20" width="10%" align="center">ID</td>
                        <td width="20%" align="left">Username</td>
                        <td width="8%" align="center">Enabled</td>
                        <td width="62%" align="left">Options</td>
                    </tr>
                    
                    <?php if($accounts->num_rows() > 0) {?>
                        
                        <?php foreach ($accounts->result() as $row): ?>
                            <tr class="main_text">
                                <td align="center"><?php echo $row->id; ?></td>
                                <td align="left"><?php echo $row->username; ?></td>
                                
                                <td align="center"><input type="checkbox" id="<?php echo $row->id;?>" class="enable_checkbox" <?php if($row->enabled == 1){ echo 'checked="checked"';}?>/></td>
                                
                                <td align="left"><a href="#" id="<?php echo $row->id;?>" class="delete_account"><img src="<?php echo base_url();?>assets/images/button_cancel.png" style="width:16px;margin-left:15px;border:none;cursor:pointer;" /></a></td>
                                
                            </tr>
                        <?php endforeach;?>
                        
                    <?php } else { echo '<tr><td align="center" colspan="4" style="color:red;">No Results Found</td></tr>'; } ?>                    
                    </tbody>
                </table>
            </td>
        </tr>
        
        <tr>
            <td id="paginationWKTOP">
                <?php echo $this->pagination->create_links();?>
            </td>
        </tr>
    </tbody></table>
    
    <div id="dialog-confirm-enable" title="Enable The Account?" style="display:none;">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are You Sure Want To Enable This Account?</p>
    </div>
    
    <div id="dialog-confirm-disable" title="Disable The Account?" style="display:none;">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are You Sure Want To Disable This Account?</p>
    </div>
    
    <div id="dialog-confirm-delete" title="Delete The Account?" style="display:none;">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are You Sure Want To Delete This Account?</p>
    </div>

    <script type="text/javascript">
        $('.enable_checkbox').click(function(){
            var curr_chk = $(this);
            var id = $(this).attr('id');
            var enable = '';
            
            if ($(this).is(':checked'))
            {
                enable = 1;
            }
            else
            {
                enable = 0;
            }
            
            if(enable == 1)
            {
                $( "#dialog-confirm-enable" ).dialog({
                    resizable: false,
                    height:180,
                    modal: true,
                    buttons: {
                        "Continue": function() {
                            var data  = 'account_id='+id+'&status=1';
                            $.ajax({
                                type: "POST",
                                url: base_url+"manage_accounts/enable_disable_account",
                                data: data,
                                success: function(html){
                                    $( "#dialog-confirm-enable" ).dialog( "close" );
                                    $('.success').html("Account Enabled Successfully.");
                                    $('.success').fadeOut();
                                    $('.success').fadeIn();
                                    document.getElementById('success_div').scrollIntoView();
                                }
                            });
                        },
                        Cancel: function() {
                            $( this ).dialog( "close" );
                            curr_chk.attr('checked', false);
                        }
                    }
                });
            }
            else
            {
                $( "#dialog-confirm-disable" ).dialog({
                    resizable: false,
                    height:180,
                    modal: true,
                    buttons: {
                        "Continue": function() {
                            var data  = 'account_id='+id+'&status=0';
                            $.ajax({
                                type: "POST",
                                url: base_url+"manage_accounts/enable_disable_account",
                                data: data,
                                success: function(html){
                                    $( "#dialog-confirm-disable" ).dialog( "close" );
                                    $('.success').html("Account Disabled Successfully.");
                                    $('.success').fadeOut();
                                    $('.success').fadeIn();
                                    document.getElementById('success_div').scrollIntoView();
                                }
                            });
                        },
                        Cancel: function() {
                            $( this ).dialog( "close" );
                            curr_chk.attr('checked', true);
                        }
                    }
                });
            }
        });
        
        $('.delete_account').live('click', function(){
            var id = $(this).attr('id');
            var curr_row = $(this).parent().parent();
            
            $( "#dialog-confirm-delete" ).dialog({
                    resizable: false,
                    height:180,
                    modal: true,
                    buttons: {
                        "Continue": function() {
                            var data  = 'account_id='+id;
                            $.ajax({
                                type: "POST",
                                url: base_url+"manage_accounts/delete_account",
                                data: data,
                                success: function(html){
                                    $( "#dialog-confirm-delete" ).dialog( "close" );
                                    curr_row.fadeOut();
                                    $('.success').html("Account Deleted Successfully.");
                                    $('.success').fadeOut();
                                    $('.success').fadeIn();
                                    document.getElementById('success_div').scrollIntoView();
                                }
                            });
                        },
                        Cancel: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                });
                
                return false;
        });
        
        $('#reset').live('click', function(){
            $('#filter_table input[type="text"]').val('');
            $('#filter_table select').val('');
            return false;
        });
        
        $('#new_account_type').change(function(){
            if($(this).val() != '')
            {
                $('#new_account_type_form').submit();
            }
        });
    </script>