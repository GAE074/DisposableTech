<script type="text/javascript">
  // Splits the Selection value and sends the results to proper form fields
  // Output values used for Simbrief acdata field generation
  const paxwgt = Math.round({{ $pax_weight }} + {{ $bag_weight }});
  const unitwgt = String("{{ setting('units.weight') }}");
  const rvr = String("{{ $sb_rvr ?? '500' }}");
  const rmktext = String("{{ $sb_rmk ?? config('app.name') }}").toUpperCase();
  const kgstolbs = Number(2.20462262185);
  function ChangeSpecs() {
    let str = document.getElementById("addon").value;
    if (str === "0") {
      document.getElementById("dow").value = "--";
      document.getElementById("mzfw").value = "--";
      document.getElementById("mtow").value = "--";
      document.getElementById("mlw").value = "--";
      document.getElementById("maxfuel").value = "--";
      document.getElementById("fuelfactor").value = "P00";
      document.getElementById("acdata").value = "{'extrarmk':'RVR\/" + rvr +" RMK\/TCAS " + rmktext + "','paxwgt':" + paxwgt + "}";
      document.getElementById("tdPayload").title = "Calculation Not Possible !";
    } else {
      // Define Dividers
      let d1 = str.search("#1#");
      let d2 = str.search("#2#");
      let d3 = str.search("#3#");
      let d4 = str.search("#4#");
      let d5 = str.search("#5#");
      let d6 = str.search("#6#");
      let d7 = str.search("#7#");
      let d8 = str.search("#8#");
      let d9 = str.search("#9#");
      let d10 = str.search("#10#");
      let d11 = str.search("#11#");
      // Read Values Between Dividers
      let id    = Number(str.slice(0, d1));
      let dow   = Number(str.slice(d1+3,d2));
      let mzfw  = Number(str.slice(d2+3,d3));
      let mtow  = Number(str.slice(d3+3,d4));
      let mlw   = Number(str.slice(d4+3,d5));
      let mfuel = Number(str.slice(d5+3,d6));
      let sbff  = String(str.slice(d6+3,d7));
      // Read Optional Values for ATC Equipment
      if (d8 > 0) {
        cat = String(str.slice(d7+3,d8));
        equip = String(str.slice(d8+3,d9));
        transponder = String(str.slice(d9+3,d10));
        pbn = String(str.slice(d10+4,d11));
      }
      // Populate Fields with Avilable Data
      if (dow > 0) {
        document.getElementById("dow").value = dow;
      } else {
        document.getElementById("dow").value = "--";
      }
      if (mzfw > 0) {
        document.getElementById("mzfw").value = mzfw;
      } else {
        document.getElementById("mzfw").value = "--";
      }
      if (mtow > 0) {
        document.getElementById("mtow").value = mtow;
      } else {
        document.getElementById("mtow").value = "--";
      }
      if (mlw > 0) {
        document.getElementById("mlw").value = mlw;
      } else {
        document.getElementById("mlw").value = "--";
      }
      if (mfuel > 0) {
        document.getElementById("maxfuel").value = mfuel;
      } else {
        document.getElementById("maxfuel").value = "--";
      }
      if (sbff.length === 3) {
        document.getElementById("fuelfactor").value = sbff;
      } else {
        document.getElementById("fuelfactor").value = "P00";
      }
      // Provide A Clue About Possible Unlerload
      if (dow > 0 && mzfw > 0) {
        document.getElementById("tdPayload").title = "ZFW Underload: " + String((mzfw - dow) - Number({{ $tpayload }})) + " " + unitwgt;
      } else {
        document.getElementById("tdPayload").title = "Calculation Not Possible !";
      }
      // Convert Values To Meet SimBrief Requirements
      // All must be thousands of lbs with 3 decimal digits except paxwgt
      if (unitwgt === "kg") {
        dowsb   = ((dow * kgstolbs) / 1000).toFixed(3);
        mzfwsb  = ((mzfw * kgstolbs) / 1000).toFixed(3);
        mtowsb  = ((mtow * kgstolbs) / 1000).toFixed(3);
        mlwsb   = ((mlw * kgstolbs) / 1000).toFixed(3);
        mfuelsb = ((mfuel * kgstolbs) / 1000).toFixed(3);
      } else {
        dowsb   = (dow / 1000).toFixed(3);
        mzfwsb  = (mzfw / 1000).toFixed(3);
        mtowsb  = (mtow / 1000).toFixed(3);
        mlwsb   = (mlw / 1000).toFixed(3);
        mfuelsb = (mfuel / 1000).toFixed(3);
      }
      // Build SimBrief ACDATA field with the fields defined
      // {'oew': ,'mzfw': ,'mtow': ,'mlw': ,'maxfuel': ,'paxwgt':}
      let acdata = "{";
      if (dowsb > 0) {acdata = acdata + "'oew':" + dowsb + ",";}
      if (mzfwsb > 0) {acdata = acdata + "'mzfw':" + mzfwsb + ",";}
      if (mtowsb > 0) {acdata = acdata + "'mtow':" + mtowsb + ",";}
      if (mlwsb > 0) {acdata = acdata + "'mlw':" + mlwsb + ",";}
      if (mfuelsb > 0) {acdata = acdata + "'maxfuel':" + mfuelsb + ",";}
      // Build ATC Equipment Part if provided
      // {"cat":"M","equip":"SDE3FGHIRWY","transponder":"S","pbn":"PBN\/A1B1C1D1"}
      if (d8 > 0) {
        acdata = acdata + "'cat':'" + cat + "','equip':'" + equip + "','transponder':'" + transponder + "','pbn':'PBN\/" + pbn + "',"; 
      }
      acdata = acdata + "'extrarmk':'RVR\/" + rvr +" RMK\/TCAS " + rmktext + "','paxwgt':" + paxwgt + "}";
      // Write ACDATA field with defined and converted values
      document.getElementById("acdata").value = acdata;
    }
  }
</script>
