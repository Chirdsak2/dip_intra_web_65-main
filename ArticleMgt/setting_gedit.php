<!--<div class="form-group row">
											<div class="col-md-12 col-sm-12 col-xs-12">
											<label for="txt_url"><?= "การแสดงผลของหน้าอ่านทั้งหมด"; ?> : </label>			
												<div class="checkbox">	  
												<label class="checkbox-inline"><input name="gshowsearch" type="checkbox"  id="gshowsearch"  value="Y" <?php if ($G["c_show_search"] == 'Y') {
                                                                                                                                                            echo 'checked';
                                                                                                                                                        } ?>>&nbsp;แสดง "ค้นหาข่าว"&nbsp;</label>
												<label class="checkbox-inline"><input name="gshowsub" type="checkbox" id="gshowsub"  value="Y" <?php if ($G["c_show_sub"] == 'Y') {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>&nbsp;แสดงหมวดย่อย&nbsp;</label>
												<label class="checkbox-inline"><input name="gshowsubnew" type="checkbox" id="gshowsubnew"   value="Y" <?php if ($G["c_show_subnew"] == 'Y') {
                                                                                                                                                            echo 'checked';
                                                                                                                                                        } ?>>&nbsp;แสดงข่าวภายใต้หมวดย่อย&nbsp;</label>
												<label class="checkbox-inline"><input name="gshowdetail" type="checkbox" id="gshowdetail"  value="Y" <?php if ($G["c_show_detail"] == 'Y') {
                                                                                                                                                            echo 'checked';
                                                                                                                                                        } ?>>&nbsp;แสดงรายละเอียดข่าว&nbsp;</label>
												<input name="select_template" type="hidden" value="0">
												</div>	
												</div>	 
										</div>-->
<div class="form-group row ">
    <label for="gtype" class="col-sm-12 control-label"><b><?= $txt_article_group_set_viewmore; ?> :</b></label>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <!-- <div class="checkbox">
													<label>
														<input name="gshowsearch" id="gshowsearch" type="checkbox" value="Y" <?php if ($G['c_show_search'] == 'Y') {
                                                                                                                                    echo 'checked="checked"';
                                                                                                                                } ?> />
														<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span><?= $txt_article_group_show_search; ?>
													</label>
												</div> -->
        <div class="checkbox">
            <label>
                <input name="gshowsub" id="gshowsub" type="checkbox" value="Y" <?php if ($G['c_show_sub'] == 'Y') {
                                                                                    echo 'checked="checked"';
                                                                                } ?> />
                <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span><?= $txt_article_group_show_sub; ?>
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input name="gshowsubnew" id="gshowsubnew" type="checkbox" value="Y" <?php if ($G['c_show_subnew'] == 'Y') {
                                                                                            echo 'checked="checked"';
                                                                                        } ?> />
                <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span><?= $txt_article_group_show_subnew; ?>
            </label>
        </div>
        <!-- <div class="checkbox">
													<label>
														<input name="gshowdetail" id="gshowdetail" type="checkbox" value="Y" <?php if ($G['c_show_detail'] == 'Y') {
                                                                                                                                    echo 'checked="checked"';
                                                                                                                                } ?> />
														<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span><?= $txt_article_group_show_detail; ?>
													</label>
												</div> -->
    </div>
</div>

<!--<div class="form-group row">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<label for="txt_url"><?= "การแสดงภาพประกอบข่าว"; ?> : </label>
													<div class="radio">		
													<label class="radio-inline"><input type="radio" name="gshowpic" value="" <?php if ($G['c_show_pic'] == "") {
                                                                                                                                    echo "checked";
                                                                                                                                } ?>>&nbsp;ไม่ใช้รูปภาพ&nbsp;</label>
													<label class="radio-inline"><input type="radio" name="gshowpic" value="@detail_news#"  <?php if ($G['c_show_pic'] == "@detail_news#") {
                                                                                                                                                echo "checked";
                                                                                                                                            } ?>>&nbsp;แสดงรูปประกอบของข่าว&nbsp;</label>
													<label class="radio-inline"><input type="radio" name="gshowpic" value="<?php if ($G['c_show_pic'] != "@detail_news#") {
                                                                                                                                echo $G['c_show_pic'];
                                                                                                                            } ?>"  <?php if ($G['c_show_pic'] != "@detail_news#" and $G['c_show_pic'] != "") {
                                                                                                                                        echo "checked";
                                                                                                                                    } ?> > 
													<a href="#pop" onClick="choose_pic('window.opener.document.form1.gshowpic[2].value','window.opener.document.all.imgpreview');document.form1.gshowpic[2].checked=true;">

													<button type="button" class="btn btn-info  btn-sm " >
													<span class="glyphicon glyphicon-folder-open"></span>&nbsp;เลือกไฟล์
													</button>
													
													
													</a><img src="<?php if ($G['c_show_pic'] != "@detail_news#" and $G['c_show_pic'] != "") {
                                                                        echo "../ewt/" . $_SESSION['EWT_SUSER'] . "/" . $G['c_show_pic'];
                                                                    } else {
                                                                        echo "../images/o.gif";
                                                                    } ?>" name="imgpreview" width="1" height="1" border="0" align="absmiddle" id="imgpreview"><?php if ($G["c_show_pic"] != "@detail_news#") {
                                                                                                                                                                    echo $G["c_show_pic"];
                                                                                                                                                                } ?>
													<? //="../ewt/".$_SESSION["EWT_SUSER"]."/".$G["c_show_pic"] 
                                                    ?>
													</label>
											</div>	
												</div>

											</div>-->
<!-- <div class="form-group row ">
    <label for="gtype" class="col-sm-12 control-label"><b><?= $txt_article_group_set_image; ?> <span class="text-danger"><code>*</code></span> :</b></label>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="radio">
            <label><input type="radio" name="gshowpic" id="ck_gshowpic1" value="Y" <?php if ($G['c_show_pic'] == "Y") {
                                                                                        echo "checked";
                                                                                    } ?> /><?= $txt_article_group_image_yes; ?>
                <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
            </label>
        </div>

        <div class="radio">
            <label><input type="radio" name="gshowpic" id="ck_gshowpic0" value="N" <?php if ($G['c_show_pic'] == "N" || $G['c_show_pic'] == "") {
                                                                                        echo "checked";
                                                                                    } ?> /><?= $txt_article_group_image_no; ?>
                <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
            </label>
        </div>

        <div class="radio">
            <label><input type="radio" name="gshowpic" id="ck_gshowpic2" <?php if ($G['c_show_pic'] != "Y" && $G['c_show_pic'] != "N") {
                                                                                echo "checked";
                                                                            } ?>>แสดงไอคอนประกอบข่าว
                <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
                <a href="#pop" onClick="choose_pic('window.opener.document.form1.gshowpic[2].value','window.opener.document.all.imgpreview');document.form1.gshowpic[2].checked=true;">
                    <button type="button" class="btn btn-info  btn-sm ">
                        <span class="glyphicon glyphicon-folder-open"></span>&nbsp;เลือกไฟล์
                    </button>
                    <img src="<?php if ($G['c_show_pic'] != "Y" and $G['c_show_pic'] != "") {
                                    echo "../ewt/" . $_SESSION['EWT_SUSER'] . "/" . $G['c_show_pic'];
                                } else {
                                    echo "../images/o.gif";
                                } ?>" name="imgpreview" id="imgpreview" width="16" height="16" border="0" align="absmiddle">
                </a>
            </label>
        </div>

        <div class="radio">
													<label><input type="radio" name="gshowpic" id="ck_gshowpic2" value="<?php if ($G['c_show_pic'] != "Y") {
                                                                                                                        } ?>"><?= $txt_article_group_image_select; ?>
														<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
														<a href="#pop" onClick="choose_pic('window.opener.document.form1.gshowpic[2].value','window.opener.document.all.imgpreview');document.form1.gshowpic[2].checked=true;">
															
														<img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle">

															<button type="button" class="btn btn-info  btn-sm ">
																<span class="glyphicon glyphicon-folder-open"></span>&nbsp;เลือกไฟล์
															</button>
															<img src="<?php if ($G['c_show_pic'] != "Y" and $G['c_show_pic'] != "") {
                                                                            echo "../ewt/" . $_SESSION['EWT_SUSER'] . "/" . $G['c_show_pic'];
                                                                        } else {
                                                                            echo "../images/o.gif";
                                                                        } ?>" name="imgpreview" width="16" height="16" border="0" align="absmiddle" id="imgpreview"> 
																		<?php if ($G["c_show_pic"] != "Y") {
                                                                        } ?>
														</a>
													</label>
												</div> 
    </div>
</div> -->

<!--<div class="form-group row">
											<div class="col-md-12 col-sm-12 col-xs-12">
											<label for="txt_url"><?= "การแสดงวันที่ข่าว"; ?> : </label>        
												<div class="radio">			
												<label class="radio-inline"><input name="gshowdate" type="radio" id="gshowdate"  value="" <?php if ($G['c_show_date'] == "") {
                                                                                                                                                echo "checked";
                                                                                                                                            } ?>>&nbsp;ไม่แสดง&nbsp;</label>
												<label class="radio-inline"><input name="gshowdate" type="radio"  id="gshowdate" value="C" <?php if ($G['c_show_date'] == "C") {
                                                                                                                                                echo "checked";
                                                                                                                                            } ?>>&nbsp;แสดงต่อจากหัวข้อข่าว&nbsp;</label>
												<label class="radio-inline"><input name="gshowdate" type="radio" id="gshowdate"  value="N" <?php if ($G['c_show_date'] == "N") {
                                                                                                                                                echo "checked";
                                                                                                                                            } ?>>&nbsp;แสดงบรรทัดถัดมา&nbsp;</label>	
												</div>	
											</div>	 
										</div>-->

<!-- <div class="form-group row">
    <label for="gshowdate" class="col-sm-12 control-label"><b><?= $txt_article_group_set_date; ?> <span class="text-danger"><code>*</code></span> :</b></label>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="radio">
            <label>
                <input type="radio" name="gshowdate" id="ck_gshowdate1" value="Y" <?php if ($G['c_show_date'] == "Y") {
                                                                                        echo "checked";
                                                                                    } ?> />
                แสดงวันที่
                <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
            </label>
        </div>
        <div class="radio">
            <label><input type="radio" name="gshowdate" id="ck_gshowdate0" value="N" <?php if ($G['c_show_date'] == "N" || $G['c_show_date'] == "") {
                                                                                            echo "checked";
                                                                                        } ?> /><?= $txt_article_group_date_no; ?>
                <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
            </label>
        </div>
         <div class="radio">
													<label><input type="radio" name="gshowdate" id="ck_gshowdate1" value="C" <?php if ($G['c_show_date'] == "C") {
                                                                                                                                    echo "checked";
                                                                                                                                } ?> /><?= $txt_article_group_date_show1; ?>
														<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
													</label>
												</div> 
    </div>
</div> -->

<?php //if ($check_org["count"] > 0) { ?>
    <!-- <div class="form-group row">
        <label for="gshowdate" class="col-sm-12 control-label"><b>ตั้งค่ารูปแบบพิเศษ <span class="text-danger"><code>*</code></span> :</b></label>
        <div class="col-md-12 col-sm-12 col-xs-12">

            <div class="radio">
                <label>
                    <input type="radio" name="c_show_org_chk" id="c_show_org_chk" value="Y" <?php echo ($chk_display == "Y" ? "checked" : null); ?> onclick="displayOrg();">แสดง
                    <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
                </label>
            </div>

            <div class="radio">
                <label>
                    <input type="radio" name="c_show_org_chk" id="c_show_org_chk" value="N" <?php echo ($chk_display == "Y" ? null : "checked"); ?> onclick="closeOrg();">ไม่แสดง
                    <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
                </label>
            </div>
        </div>
    </div>

    <div class="row" id="list_org" style="<?php echo $chk_display == "Y" ? "display: block;" : "display: none;" ?>">
        <div class="form-group row">
            <div class="col-md-2 col-sm-2 col-xs-2">
                <label class="col-sm-12 control-label"><b>เมนู</b></label>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3">
                <select class="form-control select2" name="menu_org" id="menu_org">
                    <option value="">เลือกข้อมูล</option>
                    <?php foreach ($menu_org["data"] as $key => $value) { ?>
                        <option value="<?php echo $value['m_id']; ?>" <?php echo ($chk_menu == $value['m_id'] ? "selected" : null) ?>>
                            <?php echo $value['m_name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-2 col-sm-2 col-xs-2">
                <label class="col-sm-12 control-label"><b>แบนเนอร์</b></label>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3">
                <select class="form-control select2" name="banner_org" id="banner_org">
                    <option value="">เลือกข้อมูล</option>
                    <?php foreach ($banner_org["data"] as $key => $value) { ?>
                        <option value="<?php echo $value['banner_gid']; ?>" <?php echo ($value['banner_gid'] == $chk_banner ? "selected" : null); ?>>
                            <?php echo $value['banner_name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div> -->

        <!-- <div class="form-group row">
													<div class="col-md-2 col-sm-2 col-xs-2">
														<label class="col-sm-12 control-label"><b>รูปแบนเนอร์</b></label>
													</div>
													<div class="col-md-3 col-sm-3 col-xs-3">
														<div class="row">
															<div class="column" id="list_banner_org">
																<?php
                                                                if (!$chk_banner != 0) { ?>
																	<img src="<?php echo $Globals_Dir . $banner_org["data"]["banner_pic"]; ?>" style="width: 100%; height: auto; max-height: 160px;">
																<?php } ?>
															</div>
														</div>
													</div>
												</div> -->

        <!-- <div class="form-group row">
            <div class="col-md-2 col-sm-2 col-xs-2">
                <label class="col-sm-12 control-label"><b>รูปภาพ</b></label>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3">
                <select class="form-control select2" name="image_org" id="image_org">
															<?php foreach ($image_org["data"] as $key => $value) { ?>
																<option value="<?php echo $value['banner_id']; ?>" <?php echo ($value['banner_id'] == $chk_image ? "selected" : null); ?>>
																	<?php echo $value['banner_name']; ?>
																</option>
															<?php } ?>
														</select>
                <input type="file" class="form-control" name="image_org" id="image_org">
            </div>
        </div> -->

        <!-- <div class="form-group row">
													<div class="col-md-2 col-sm-2 col-xs-2">
														<label class="col-sm-12 control-label"><b>รูปภาพ</b></label>
													</div>
													<div class="col-md-3 col-sm-3 col-xs-3">
														<div class="row">
															<div class="column" id="list_banner_org">
																<?php
                                                                if ($chk_image != 0) { ?>
																	<img src="<?php echo $Globals_Dir . $image_org["data"]["banner_pic"]; ?>" style="width: 100%; height: auto; max-height: 160px;">
																<?php } ?>
															</div>
														</div>
													</div>
												</div> -->

        <!-- <div class="form-group row">
            <div class="col-md-2 col-sm-2 col-xs-2">
                <label class="col-sm-12 control-label"><b>ข่าวหมวดที่ 1</b></label>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3">
                <select class="form-control select2" name="org_group1" id="org_group1">
                    <option value="">เลือกข้อมูล</option>
                    <?php foreach ($group_org["data"] as $key => $value) { ?>
                        <option value="<?php echo $value['c_id']; ?>" <?php echo ($chk_org1 == $value['c_id'] ? "selected" : null) ?>>
                            <?php echo $value['c_name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-2 col-sm-2 col-xs-2">
                <label class="col-sm-12 control-label"><b>ข่าวหมวดที่ 2</b></label>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3">
                <select class="form-control select2" name="org_group2" id="org_group2">
                    <option value="">เลือกข้อมูล</option>
                    <?php foreach ($group_org["data"] as $key => $value) { ?>
                        <option value="<?php echo $value['c_id']; ?>" <?php echo ($chk_org2 == $value['c_id'] ? "selected" : null) ?>>
                            <?php echo $value['c_name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-2 col-sm-2 col-xs-2">
                <label class="col-sm-12 control-label"><b>ข่าวหมวดที่ 3</b></label>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3">
                <select class="form-control select2" name="org_group3" id="org_group3">
                    <option value="">เลือกข้อมูล</option>
                    <?php foreach ($group_org["data"] as $key => $value) { ?>
                        <option value="<?php echo $value['c_id']; ?>" <?php echo ($chk_org3 == $value['c_id'] ? "selected" : null) ?>>
                            <?php echo $value['c_name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div> -->
<?php //} ?>