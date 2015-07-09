$(document).ready(function() {

  // load walkthrough styles
  $(function() {
    $('<link/>', {
      rel: 'stylesheet',
      type: 'text/css',
      href: 'http://moodle.warwick.ac.uk/theme/warwickclean/style/nazanin.css'
    }).appendTo('head');
  $('<link/>', {
    rel: 'stylesheet',
    type: 'text/css',
    href: 'http://moodle.warwick.ac.uk/theme/warwickclean/style/introjs.css'
  }).appendTo('head');
});

var url = window.location.href;

// Step 1
if (url == 'http://moodle.warwick.ac.uk/course/view.php?id=11832') {
  $('#page-navbar > nav > div > form > div > input[type="submit"]:nth-child(1)').attr({
    'data-intro': 'In this walkthrough you will learn how to add a Quiz to your Moodle course page and about some of the commonly used Quiz settings.<p><strong>Click \'Turn editing on\' to get started.</strong></p>',
    'data-step': 1
  });

  $('#launch_walk').on('click', function() {
    $("html, body").animate({ scrollTop: 0 }, "slow");
    introJs().setOptions({
      exitOnOverlayClick: false,
      showButtons: true
    }).start();
  });
}

if (url == 'http://moodle.warwick.ac.uk/course/view.php?id=11832&notifyeditingon=1') {
  $('#section-1').attr({
    "data-intro": "Under the \'Quizzes\' heading, click <strong>\'Add activity or resource\'</strong>",
    "data-step": 2,
    "data-position": "left"
  });
  introJs().setOptions({
    exitOnOverlayClick: false,
    showButtons: true
  }).start();

  $('#section-1 .section-modchooser-text').on('click', function() {
    introJs().exit();

    setTimeout(function() {
      $('.path-course-view.moodle-dialogue-base.moodle-dialogue').attr(
        "style", "z-index: 9999999 !important;"
      );
      $('.moodle-dialogue-base.yui3-widget').attr(
        "style", "z-index: 9999999 !important;"
      );
    }, 200);

    setTimeout(function() {
      $('.yui3-widget-mask.moodle-dialogue-lightbox').css("display", "none");
      top = $('div.moodle-dialogue-base > div:nth-child(2)').css("top");
      left = $('div.moodle-dialogue-base > div:nth-child(2)').css("left");
      $('div.moodle-dialogue-base > div:nth-child(2)').attr({
        "data-intro": "Select Quiz activity and click Add",
        "data-step": 3,
        "data-position": "right",
        "style": "top: " + top + "; left: " + left + "; width: 540px; z-index: 9999999 !important"
      });


      introJs().setOptions({
        exitOnOverlayClick: false,
        disableInteraction: false
      }).start().nextStep();
    }, 300);
  });
}

if (url.indexOf("modedit.php?add=quiz&type=&course=11832") > 0) {
  $('#fitem_id_name').attr({
    "data-intro": "You must give your Quiz a name, this will identify it on the Moodle course page. When you\'re done, click \'Next\'",
    "data-position": "left"
  });
  $('#id_name').attr("value", "My First Quiz");
  $('#fitem_id_introeditor').attr({
    "data-intro": "An optional description that will be displayed below the Quiz link on the course page",
    "data-position": "left"
  });
  $('#id_timing').attr({
    "data-intro": "Other Quiz settings can be expanded on this page.\n\nQuiz accessibility is opened ended by default, click \'Enable\' next to Open and Close times to change this. Similarly for \'Time Limit\'.\n\nClicking the question mark icons on this page offer further information about settings if you are unsure",
    "data-position": "left"
  });
  $('#id_modstandardgrade').attr({
    "data-intro": "These settings relate to how many Quiz attempts are allowed per student, and how the student's grade will be counted againt their grades in Moodle",
    "data-position": "left"
  });
  $('#id_interactionhdr').attr({
    "data-intro": "For multiple-choice or matching questions you can set it so that answers are shuffled per attempt. More information on question behaviour can be found in <a href=\"https://docs.moodle.org/28/en/Question_behaviours\">Moodle documentation</a>",
    "data-position": "left"
  });
  $('#id_overallfeedbackhdr').attr({
    "data-intro": "As well as feedback which can be set per question, here you can specify feedback presented to students upon quiz completion. This can be arranged according to grade boundaries.\n\nSome example grade boundaries are provided here, feel free to change these and add some text in the \'feedback\' box.",
    "data-position": "left"
  });
  $('#id_submitbutton').attr({
    "data-intro": "There are more settings you might consider on this page, but for now click the \'Save and display\' button to be taken to your newly created quiz, ready to begin adding questions",
    "data-position": "left"
  });

  introJs().setOptions({
    exitOnOverlayClick: false,
    disableInteraction: false
  }).start().onbeforechange(function(targetElementId) {

    switch (targetElementId.id) {
      case 'id_timing':
      case 'id_modstandardgrade':
      case 'id_interactionhdr':
        $('#' + targetElementId.id).removeClass("collapsed");
        break;

      case 'id_overallfeedbackhdr':
        $('#' + targetElementId.id).removeClass("collapsed");
        $('#id_feedbackboundaries_0').attr("value", "80%");
        $('#id_feedbackboundaries_1').attr("value", "70%");
        $('#id_feedbackboundaries_2').attr("value", "55%");
        $('#id_feedbackboundaries_3').attr("value", "40%");
        break;
      default:
        break;

    }
  });
}

});
