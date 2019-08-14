jQuery.noConflict();
         (function($){
            var reveChatBaseURL = 'https://dashboard.revechat.com/';
            var ReveChat ={
               init: function () {
                  this.toggleForms();
                  this.bindFormSubmit();
               },

               toggleForms: function ()
              {
                  var toggleForms = function ()
                  {
                      if ($('#new_revechat_account').is(':checked'))
                      {
                          $('#revechat_already_have').hide();
                          $('#revechat_new_account').show();
                          $('#edit-name').focus();
                      }
                      else if ($('#has_revechat_account').is(':checked'))
                      {
                          $('#revechat_new_account').hide();
                          $('#revechat_already_have').show();
                          $('#edit-revechat-account-email').focus();
                      }
                  };
                  toggleForms();
                  $('#revechat_choose_form input').click(toggleForms);
              },

              bindFormSubmit: function () {
                  $('#revechat-admin-settings-form').submit(function(e)
                  {
                      //e.preventDefault();
                      if (((parseInt($('input[name=revechat_aid]').val()) !== 0)) || $('#has_revechat_account').is(':checked'))
                      {
                          return ReveChat.alreadyHaveAccountForm();
                      }
                      else
                      {
                          return ReveChat.newLicenseForm();
                      }

                  });
              },

              alreadyHaveAccountForm: function()
              {
                  if(this.validEmail())
                  {
                      if((parseInt($('input[name=revechat_aid]').val()) == 0))
                      {
                          var login = $.trim($('#edit-revechat-account-email').val());
                          if(!login.length)
                          {
                              $('#edit-revechat-account-email').focus();
                              return false;
                          }
                          $('#revechat_already_have .ajax_message').removeClass('message').addClass('wait').html('Please wait&hellip;');
                           var signInUrl = reveChatBaseURL +'/license/adminId/'+$('#edit-revechat-account-email').val()+'/?callback=?';

                          $.getJSON(signInUrl,
                              function(response)
                              {

                                  if (response.error)
                                  {
                                      $('#revechat_already_have .ajax_message').removeClass('wait').addClass('message alert').html('Incorrect REVE Chat login.');
                                      $('#edit-revechat-account-email').focus();
                                      return false;
                                  }
                                  else
                                  {
                                      $('input[name=revechat_aid]').val(response.data.account_id);

                                      $('#revechat-admin-settings-form').submit();
                                  }
                              });
                          return false;
                      }
                  }
                  else
                  {
                      $('#revechat_already_have .ajax_message').removeClass('wait').addClass('message alert').html('Invalid Email.');
                      $('#edit-revechat-account-email').focus();
                      return false;
                  }
                  return true;
              },

              newLicenseForm: function()
              {
                  if (parseInt(($('input[name=revechat_aid]').val()) > 0))
                  {
                      return true;
                  }

                  if(this.validateNewLicenseForm())
                  {
                      $('#revechat_new_account .ajax_message').removeClass('message').addClass('wait').html('Please wait...');

                      ReveChat.createLicense();
                  }
                  return false;
              },
              createLicense: function()
              {

                  $('#revechat_new_account .ajax_message').removeClass('message').addClass('wait').html('Creating new account&hellip;');

                  var signUpUrl = reveChatBaseURL + '/revechat/rest/api/signup.do';

                  $.ajax({
                     data: { 'firstname':$('#edit-name').val(), 'lastname':' ', 'mailAddr':$('#edit-email').val(), 'phoneNo':$('#edit-phone').val() },
                     type:'POST',
                     url:signUpUrl,
                     dataType: 'json',
                     cache:false,
                     success: function(response) {
                          if(response.error)
                          {
                              $('#revechat_new_account .ajax_message').html(response.error).addClass('message alert').removeClass('wait');
                              return false;
                          }
                          else if(response.success)
                          {
                             $('#revechat-admin-settings-form').children('div').remove();
                              var message = '<div class="revechat_success_message">';
                              message += '<h3>Thank you for sigining up with REVE Chat</h3>';
                              message += '<p>A verification link has been sent to your registered email address from <strong>support@revechat.com</strong>. Kindly verify your email to complete the signup process</p>';
                              message += '<p>Then come backe again to integrate REVE Chat in your website.</p>';
                              message += '</div>';
                              $(message).appendTo('#revechat-admin-settings-form');
                              return false;
                          }
                         }
                    });
              },
              validEmail: function()
              {

                  if($('#edit-submit').val() != 'Remove')
                  {
                      if (/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,6}$/i.test($('#edit-revechat-account-email').val()) == false)
                      {
                          //alert ('Please enter a valid email address.');
                          $('#edit-email').focus();
                          return false;
                      }
                  }
                  return true;
              },

              validateNewLicenseForm: function()
              {
                  if ($('#edit-name').val().length < 1)
                  {
                      alert ('Please enter your full name.');
                      $('#edit-name').addClass('error').focus();
                      return false;
                  }

                  if (/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,6}$/i.test($('#edit-email').val()) == false)
                  {
                      alert ('Please enter a valid email address.');
                      $('#edit-email').addClass('error').focus();
                      return false;
                  }

                  if ($('#edit-phone').val().length < 1)
                  {
                      alert ('Please enter your phone number.');
                      $('#edit-phone').addClass('error').focus();
                      return false;
                  }

                  return true;
              }
            }
            $(document).ready(function()
             {
                ReveChat.init();
             });
         })(jQuery);