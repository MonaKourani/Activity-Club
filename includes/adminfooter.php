                
        </div>
      </div>
    </div>
    
    <!-- JS -->
    <script src="js/jquery-1.11.2.min.js"></script>      <!-- jQuery -->
    <script src="js/jquery-migrate-1.2.1.min.js"></script> <!--  jQuery Migrate Plugin -->
    <script src="https://www.google.com/jsapi"></script> <!-- Google Chart -->
    <script>
      /* Google Chart 
      -------------------------------------------------------------------*/
      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});


      $(document).ready(function(){
        if($.browser.mozilla) {
          //refresh page on browser resize
          // http://www.sitepoint.com/jquery-refresh-page-browser-resize/
          $(window).bind('resize', function(e)
          {
            if (window.RT) clearTimeout(window.RT);
            window.RT = setTimeout(function()
            {
              this.location.reload(false); /* false to get page from cache */
            }, 200);
          });      
        } else {
          $(window).resize(function(){
            drawChart();
          });  
        }
        
        $('#editUserForm').submit(function (event) {
            event.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: '/Activity Club/api/userUpdate.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (data) {
                    alert(data.message);
                },
                error: function (xhr, status, error) {
                    alert(JSON.parse(xhr.responseText).message);
                }
            });
        });
    });
      
      function deleteUser(email) {
        if (confirm("Are you sure you want to delete this user?")) {
            $.ajax({
                url: '/Activity Club/api/userDelete.php',
                type: 'GET',
                data: { email: email },
                dataType: 'json',
                success: function (data) {
                    alert(data.message);
                    $('#userTableBody').find('tr[data-email="' + email + '"]').remove();
                },
                error: function (xhr, status, error) {
                    console.error('Error: ' + error);
                }
            });
        }
      }

      function editUser(email) {
        window.location.href = '/Activity%20Club/adminEditUser.php?email=' + email;
    }


    </script>
    <script type="text/javascript" src="js/templatemo-script.js"></script>      <!-- Templatemo Script -->

  </body>
</html>
