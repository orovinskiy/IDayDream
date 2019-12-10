<?php
/**
 * This file is for getting input from the user
 * to send an email to all the active members
 */
// Included files
include('debugging.php');

function emailModal($modalId,$pageLocation)
{
    echo "<!-- modal for the email -->
    <div class='modal fade' id='$modalId'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <h3 class='modal-title titleColor text-white text-center mb-4 py-2'>Compose your email
                    <span>
                        <button type='button' class='close mt-1 mr-3' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </span>
                </h3>
                <form id='emailComposer' action='mailSender.php' method='post'>
                    <div class='modal-body'>

                        <!-- Subject -->
                        <div class='form-group' >
                            <label class=' h5 font-weight-light ' id='subjectLabel'  for='subject'>Subject </label>
                            <span id='subjectError' class='hidden error'>*Required</span>
                            <input class='required form-control shadow-sm' type='text' id='subject' maxlength='150' name='subject'>
                        </div>

                        <!-- Text Area -->
                        <div class='form-group'>
                            <label for='compose' id='composeLabel' class='h5 font-weight-light mr-sm-1'>
                                Compose your message
                            </label>
                            <span id='composeError' class='hidden error'>*Required</span>
                            <textarea id='compose' maxlength='200000' class='required form-control shadow-sm' name='compose'></textarea>
                        </div>

                        <!-- saves input from which page the user came from -->";
                        echo "'<input type='checkbox' name='select' value='$pageLocation' checked class='halfHidden'>

                        <div class='text-center pb-2'>
                            <button type='submit' id='submit' class='btn btn-dark shadow-sm mx-0 rounded-0'>Submit</button>
                        </div>

                    </div><!-- modal-body -->
                </form>
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->";
}