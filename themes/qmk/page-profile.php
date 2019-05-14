<?php
    if ( !get_current_user_id() ) {
        wp_redirect( site_url('/') );
    }
     get_header();
     $user_id = get_current_user_id();
     $args = array(
        'key' => $user_id,
        'value' => 'user_login',
        'number' => '1',
        'include' => $user_id
    );
    
    // The Query
    $user_query = new WP_User_Query( $args );
    
    // User Loop
    if ( ! empty( $user_query->get_results() ) ) {
        foreach ( $user_query->get_results() as $user ) {
            $registered = $user->user_registered;
            $registered_date = date('F Y', strtotime( $registered ));
            //If user profile image is not empty
            if ( isset( $user->profile_image ) ) {
                $image = $user->profile_image;
            } else {
                $image = 'http://www.qmk.co.za/wp-content/uploads/2018/12/banner.jpg';
            }
 ?>

<section class="bg--secondary space--sm">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-body boxed boxed--lg boxed--border profile-border__box">
                    <div class="text-block text-center">
                        <input type="hidden" name="profile_image" value="">
                            <img src="<?php echo $image; ?>" alt="<?php echo $user->nickname; ?>'s profile picture" title="<?php echo $user->nickname; ?>'s profile picture" class="artist-thumb">
                        <span class="card-title artist-name"><strong><?php echo $user->nickname; ?></strong></span>
                        <span class="badge badge-primary artform-label"><?php echo $user->artform; ?></span>
                        <span class="label">Kaffy since <?php echo $registered_date; ?></span>
                    </div>
                    <hr>
                    <div class="text-block text-center">
                        <ul class="list-inline social-buttons">
                            <?php echo show_social_icons(); ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="accordion col-lg-8" id="qmk-accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-link pl-0" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Profile
                            </button>
                            <button class="btn btn-link pl-0 edit-profile" id="user-edit" type="button">
                                Edit Profile
                            </button>
                        </h2>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#qmk-accordion">
                        <div class="card-body">  
                            <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                                <div class="form-row form-group">
                                    <div class="col">
                                        <label class="user-profile-title">First Name</label>
                                        <input type="text" class="form-control user-profile" name="first_name" value="<?php echo $user->first_name; ?>" readonly>
                                    </div>
                                    <div class="col">
                                        <label class="user-profile-title">Last Name</label>
                                        <input type="text" class="form-control user-profile" name="last_name" value="<?php echo $user->last_name; ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-row form-group">
                                    <div class="col">
                                        <label class="user-profile-title">Username</label>
                                        <input type="text" class="form-control user-profile" name="username" value="<?php echo $user->nickname; ?>" readonly>
                                    </div>
                                    <div class="col">
                                        <label for="email" class="user-profile-title">Email</label>
                                        <input type="email" class="form-control user-profile" name="email" value="<?php echo $user->user_email; ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group col-md-3 pl-0">
                                    <label for="phone_number">Phone Number</label>
                                    <input type="tel" class="form-control user-profile" name="phone_number" min="10" max="10" value="<?php echo $user->phone_number; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="biography" class="user-profile-title">Biography</label>
                                    <textarea class="form-control user-profile" name="biography" maxlength="140" readonly><?php echo $user->description; ?></textarea>
                                </div>
                                <div class="form-row form-group">
                                    <div class="col">
                                        <label for="area_code" class="user-profile-title"><?php _e( 'Area Code', 'qmk' ) ?></label>
                                        <input type="number" name="area_code" id="area_code" class="form-control user-profile" value="<?php echo $user->area_code; ?>" size="25" readonly />
                                    </div>
                                    <div class="col">
                                        <label for="artform" class="user-profile-title">Artform</label>
                                        <input class="form-control user-profile" type="text" name="artform" value="<?php echo $user->artform; ?>" readonly>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed pl-0" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Artwork
                            </button>
                        </h2>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#qmk-accordion">
                        <div class="card-body">
                                <div class="image-holder">
                                    <img src="<?php echo $user->profile_image; ?>"  alt="<?php echo $user->nickname; ?>'s profile picture">
                                </div>
                                <div class="custom-file mb-3 mt-1">
                                    <input type="hidden" id='profile-image' name="profile_image">
                                    <input type="file" id="upload-button" name="image" class="custom-file-input" onChange="displayImage(this)" value="">
                                    <label class="custom-file-label" for="customFile">Choose profile picture</label>
                                </div>
                                <div class="image-holder">
                                    <img src="<?php echo $user->image; ?>" onClick="triggerClick()" id="">
                                </div>
                                <div class="custom-file mb-3 mt-1">
                                    <input type="hidden" id='artwork-image' name="image">
                                    <input type="file" id='upload-artwork' name="artwork-image" class="custom-file-input">
                                    <label class="custom-file-label" for="customFile">Choose your first image</label>
                                </div>
                                <div class="image-holder">
                                    <img src="<?php echo $user->image1; ?>" id="">
                                </div>
                                <div class="custom-file mt-1">
                                    <input type="hidden" id='artwork-image1' name="image1">
                                    <input type="file" id="upload-artwork1" name="artwork-image1" class="custom-file-input" id="customFile" value="<?php echo $user->image1; ?>">
                                    <label class="custom-file-label" for="customFile">Choose your second image</label>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed pl-0" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Links
                        </button>
                    </h2>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#qmk-accordion">
                    <div class="card-body">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Facebook</span>
                                </div>
                                <input type="text" name="facebook" class="form-control user-profile pl-1" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Insert link starting with http" value="<?php echo $user->facebook; ?>" readonly>
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Instagram</span>
                                </div>
                                <input type="text" name="instagram" class="form-control user-profile pl-1" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Insert link starting with http" value="<?php echo $user->instagram; ?>" readonly>
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Twitter</span>
                                </div>
                                <input type="text" name="twitter" class="form-control user-profile pl-1" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Insert link starting with http" value="<?php echo $user->twitter; ?>" readonly>
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">YouTube</span>
                                </div>
                                <input type="text" name="youtube" class="form-control user-profile pl-1" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Insert link starting with http" value="<?php echo $user->youtube; ?>" readonly>
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">SoundCloud</span>
                                </div>
                                <input type="text" name="soundcloud" class="form-control user-profile pl-1" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Insert link starting with http" value="<?php echo $user->soundcloud; ?>" readonly>
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Behance</span>
                                </div>
                                <input type="text" name="behance" class="form-control user-profile pl-1" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Insert link starting with http" value="<?php echo $user->behance; ?>" readonly>
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Website</span>
                                </div>
                                <input type="text" name="website" class="form-control user-profile pl-1" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Insert link starting with http" value="<?php echo $user->website; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-row form-button-group">
                        <div class="col">
                            <input type="submit" class="btn btn-primary mb-2" name="update" value="UPDATE" />
                            <button type="button" class="btn btn-danger float-right mb-2" data-toggle="modal" data-target="#delete-modal">Delete Profile</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</section>
<?php 
        }
    } ?>
<!-- Modal -->
<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modalLabel" aria-hidden="true">
    <div class="container">
        <div class="row">
            <div class="modal-dialog col-md-6" role="document">
                <div class="modal-content">
                <div class="modal-header alert-danger">
                    <h5 class="modal-title font-weight-bolder" id="delete-modalLabel">Delete Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>You are about to permanently delete your profile. If you are sure you want to do this, click Delete. Otherwise click Cancel.</p>
                </div>
                <div class="modal-footer" data-id="<?php echo $user->ID; ?>">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" name="delete" class="btn btn-danger delete-profile">Delete</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
