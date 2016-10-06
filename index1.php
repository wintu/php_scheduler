<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
     <title>スケジュール帳</title>
     <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">
     <link rel="stylesheet" type="text/css" href="assets/zabuto_calendar.min.css">
     <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
     <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
     <script src="assets/zabuto_calendar.min.js"></script>
</head>
<body>
<h4>スケジュール帳</h4>
<div class="row">
  <div id="my-calendar"></div>
  <script type="application/javascript">
    $(document).ready(function () {
        $("#date-popover").popover(...);
        ...

        $("#my-calendar").zabuto_calendar({
            action: function () {
                return myDateFunction(this.id, false);
            },
            action_nav: function () {
                return myNavFunction(this.id);
            },
            ajax: {
                url: "show_data.php?action=1",
                modal: true
            },
            legend: [
                {type: "text", label: "Special event", badge: "00"},
                {type: "block", label: "Regular event"}
            ]
        });
    });

    function myDateFunction(id, fromModal) {
        $("#date-popover").hide();
        if (fromModal) {
            $("#" + id + "_modal").modal("hide");
        }
        var date = $("#" + id).data("date");
        var hasEvent = $("#" + id).data("hasEvent");
        if (hasEvent && !fromModal) {
            return false;
        }
        $("#date-popover-content").html('You clicked on date ' + date);
        $("#date-popover").show();
        return true;
    }

    function myNavFunction(id) {
        $("#date-popover").hide();
        var nav = $("#" + id).data("navigation");
        var to = $("#" + id).data("to");
        console.log('nav ' + nav + ' to: \ + to.month + '/' + to.year);
    }
</script>
</div>
</body>
</html>
