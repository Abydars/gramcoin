<?php
?>
<html>
<head>
    <style>
        .hppFrame {
            width: 100%;
            border: none;
            height: 342px;
        }
    </style>
    <script src="js/propay/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="js/propay/jquery.signalR-3.2.1.min.js" type="text/javascript"></script>
    <script src="js/propay/hpp-1.1.js" type="text/javascript"></script>
    <script type="text/javascript">
        /*=======================================================================================================
         The following functions are referenced by the hpp.js file and should be included on your checkout page
         ========================================================================================================*/
        //Submit Button Function
        function btnSubmitForm_Click() {
            signalR_SubmitForm();
        }
        //This function is invoked when the Hosted Payment Page and the Checkout Page are connected and the Hosted Payment Page is ready for submission
        function formIsReadyToSubmit() {
            //Do not allow the user to submit the Hosted Payment Page until this Method has been invoked
            //document.getElementById('btnSubmit').disabled = false;
            $("#btnSubmit",parent.document).removeAttr('disabled');
        }

        function loadHPP() {
            var HID = window.parent.HID;
            //if (HID == null) {
            //    alert("nothing from parent");
            //}

            hpp_Load(HID, false); //HostedTransactionIdentifier, Debug Mode
        }

        $(function() {
            loadHPP();
        })
    </script>
</head>
<body>
<iframe scrolling="no" class="hppFrame" id="hppFrame" name="hppFrame" class="iFrame"></iframe>
<input style="display: none;" type="button" id="btnSubmit" name="btnSubmit" value="Submit" class="btn btn-info pull-left" onclick="btnSubmitForm_Click()" disabled="disabled" />
</body>
</html>
