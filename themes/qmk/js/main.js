/*!
 * Code licensed under the Apache License v2.0.
 * For details, see http://www.apache.org/licenses/LICENSE-2.0.
 */

// jQuery for page scrolling feature - requires jQuery Easing plugin
$(function() {
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });
});

// Highlight the top nav as scrolling occurs
$('body').scrollspy({
    target: '.navbar-fixed-top'
})

// Closes the Responsive Menu on Menu Item Click
$('.navbar-collapse ul li a').click(function() {
    $('.navbar-toggle:visible').click();
});

//Add nav-link class to navigation links
$('.navbar-nav').find('a').addClass('nav-link');

//Add about-qmk-p class to numbered paragraphs
$('.about-qmk').find('p').addClass('about-qmk-p');
$('.page-numbers').addClass('pagination');
$('.edit-profile').on('click', function() {
    
    if($('#user-edit').hasClass('cancel')) {
        $('.card-body').find('.user-profile').attr('readonly', 'readonly');
    $('.cancel').removeClass('cancel').addClass('edit-profile').html('Edit Profile');
    } else {
        $('.card-body').find('.user-profile').removeAttr('readonly').focus();
        $('.edit-profile').removeClass('edit-profile').addClass('cancel').html('Cancel');
    }
    
});
// $('.cancel').on('click', function() {
//     $('.card-body').find('.user-profile').attr('readonly', 'readonly');
//     $('.cancel').html('Edit Profile');
// });
$('.delete-profile').on('click', function() {
    location.reload();
    window.location.href = 'http://localhost:3000/';
});

//Search
class Search {
    //Initiate the object
    constructor() {
        this.addSearchHTML();
        this.resultsDiv = $('#artists-search_results');
        this.openForm = $('.search-input_field');
        this.closeForm = $('.search-overlay__close');
        this.searchOverlay = $('.search-overlay');
        this.searchField = $('#search-term');
        this.events();
        this.typingTimer;
        this.previousValue;
        this.isSpinnerVisible = false;
        this.isOverlayOpen = false;
    }

    //Events
    events() {
        this.openForm.on('click', this.openOverlay.bind(this));
        this.closeForm.on('click', this.closeOverlay.bind(this));
        this.searchField.on('keyup', this.typingLogic.bind(this));
        $('.delete-profile').on('click', this.deleteProflle);
    }


    //Methods
    deleteProflle(e) {
        var thisProfile = $(e.target).parents('.modal-footer');
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader( 'X-WP-Nonce', qmkData.nonce );
            },
            type: "DELETE",
            url: qmkData.root_url + "/wp-json/wp/v2/users/" + thisProfile.data('id') + "?reassign=0&force=true",
            error: (response) => {
                console.log('Not deleted');
                console.log(response);
            },
            success: (response) => {
                console.log('Deleted');
                console.log(response);
            }
        });
    }
    typingLogic() {
        if (this.searchField.val() != this.previousValue) {
            clearTimeout(this.typingTimer);
            if (this.searchField.val() ) {
                if (!this.isSpinnerVisible) {
                    this.resultsDiv.html('<div class="spinner-loader"></div>');
                    this.isSpinnerVisible = true;
                }
                this.typingTimer = setTimeout(this.getResults.bind(this), 750);
            } else {
                this.resultsDiv.html('');
                this.isSpinnerVisible = false;
            }
        }
        this.previousValue = this.searchField.val();
    }
    getResults() {
       $.getJSON( qmkData.root_url + "/wp-json/wp/v2/users?search=" + this.searchField.val(), users => {
            this.resultsDiv.html(`
                ${users.length ? '<div class="portfolio-item">' : '<p>Sorry, we couldn\'t find any creative matching your search.</p>' }
                ${users.map(item =>
                    `<div class="col-md-4 col-sm-5 creative-search__result" id="artists-search_results">
                        <a href="#${item.custom_fields.nickname}" class="portfolio-link" data-toggle="modal">
                            <img src="${item.custom_fields.profile_image}" class="img-responsive" alt="51">
                            <div class="portfolio-caption mt-2">
                                <h4>${item.custom_fields.nickname}</h4>
                                <p class="text-muted"><i class="fa fa-tag"></i>&nbsp;${item.custom_fields.artform}</p>
                            </div>
                        </a>
                    </div>`).join('')}
                ${users.length ? '</div>' : '' }
            `);
            this.isSpinnerVisible = false;
           }
       );
    }
    openOverlay() {
        this.searchOverlay.addClass('search-overlay--active');
        $('body').addClass('body-no-scroll');
        this.searchField.val('');
        setTimeout( () => this.searchField.focus(), 301);
        console.log("our open method just ran");
        this.isOverlayOpen = true;
    }

    closeOverlay() {
        this.searchOverlay.removeClass('search-overlay--active');
        $('body').removeClass('body-no-scroll');
        console.log("our close method just ran");
        this.isOverlayOpen = false;
    }
    addSearchHTML() {
        $('body').append(`
        <div class="search-overlay">
            <div class="search-overlay__top mb-5">
                <div class="container">
                    <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                    <input type="text" id="search-term" class="search-term" placeholder="Type here to search artists">
                    <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
                </div>
            </div>
            <div class="container">
                <div class="row" id="artists-search_results">
                    
                </div>
            </div>
        </div>
        `);
    }
    
}
var searchQuery = new Search();