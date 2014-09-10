<script src="js/occ_info.js" type="text/javascript"></script>
<h3>Occ Info Report</h3>
<br/>
    
    <div id="occfind">
        <div id="geography">
         <select id="areacode"></select>
         <br/><br/>
        </div>
       <span class="stitle">Enter an occupation name or keyword: <br/>
       <input type="text"  id="socsearch" value="" maxlength="60"  size="40" />
       <input class="sbutn" type="submit" name="key1" value="Go" onclick="getSearchSoc(); return false" />
       <input class="sbutn" type="submit" name="keyr" value="Reset" onclick="resetSearchSoc(); return false" />
      </span>  

      <br/><br/>
      <span class="stitle">Find an occupation by clicking through the drill down hierarchy:</span> 
      <br/><br/>
      <div id="occdrill"></div>
   </div>

   <a style="display: none" href="" id="slink" onclick="$('#occfind').show() ; $('#selocc').html(''); $('#slink').hide(); return false"> &gt;&gt;&gt; Select another occupation</a>
   <br/><br/>
   <div id="selocc"></div>
  

<script type="text/javascript">
    //<![CDATA[
    
    GeogLists.stfips = '<?php echo ARConfig::stfips; ?>'
    GeogLists.include_national = 'n';
    GeogLists.include_statewide = 'y';
    GeogLists.keep = 'y';
    GeogLists.areatype = '<?php echo ARConfig::occinfo_areatype; ?>';
    GeogLists.getGeog();
    
  $("#occdrill").occmenu();
    //]]>
</script>
