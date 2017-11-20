/**
 * Main script
 */

'use strict';

/**
 * namespace
 * PBS = Pegara's Brain Salvation
 */
var PBS    = window.PBS = {};
var Util   = PBS.Util   = {};
var Widget = PBS.Widget = {};
var Page   = PBS.Page   = {};
var Route  = PBS.Route  = {
  all     : '.',
  rrs     : '^\/rrs?',
  profile : '^\/rrs\/profile',
  score   : '^\/rrs\/score',
  survey  : '^\/survey\/form'
};

/**
 * on domContentLoaded
 */
$(function() {
  // All pages
  Util.dispatcher(Route.all, function() {
    Page.all.init();
  });

  // RRS form page
  Util.dispatcher(Route.rrs, function() {
    console.log('rrs');
    Page.rrs.init();
  });

  // RRS profile form page
  Util.dispatcher(Route.profile, function() {
    console.log('profile');
    Page.profile.init();
  });

  // RRS score page
  Util.dispatcher(Route.score, function() {
    console.log('score');
    Page.score.init();
    // Page.score.scoreUp.start();
  });

  // Survey page
  Util.dispatcher(Route.survey, function() {
    console.log('survey');
    Page.survey.init();
  });

  // dispatch
  var url = location.pathname;
  Util.dispatcher(url);
});
