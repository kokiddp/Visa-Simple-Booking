require('angular');
var moment = require('moment');
require('moment/locale/it');
var _ = require('lodash');

(function( $ ) {
	'use strict';

	/**
	 * On DOM ready:
	 */
	$(function() {	
        console.log('Visa Simple Booking by Gabriele Coquillard @ VisaMultimedia');
        moment.locale('it');
	});

	/**
	 * Angular spapp:
	 */
    var app = angular.module('vsb',[]);
    
    app.config(['$compileProvider', function($compileProvider) {
        $compileProvider.debugInfoEnabled(false);
        $compileProvider.commentDirectivesEnabled(false);
        $compileProvider.cssClassDirectivesEnabled(false);
    }]);

    app.controller('vsbController',[
        "$scope",
        "$window",
        function($scope,$window) {

            $scope.internal = {
                minNights: 1,
                maxRooms: 5,
                maxPeople: 5,
                defaultAdults: 2,
                minAdultsFirstRoom: 1,
                minAdultsOtherRooms: 1,
                maxAgeChildren: 17,
                minArrivalDate: moment(new Date()).startOf('day').toDate(),
                url: '',
                queryString: '',
            }
            $scope.internal.minDepartDate = moment(new Date()).startOf('day').add(parseInt($scope.internal.minNights), 'd').toDate();
            $scope.internal.arrival = moment($scope.internal.minArrivalDate).startOf('day');
            $scope.internal.depart = moment($scope.internal.minDepartDate).startOf('day');

            $scope.form = {
                arrivalDate: moment(new Date()).startOf('day').toDate(),
                departDate: moment(new Date()).startOf('day').add(parseInt($scope.internal.minNights), 'd').toDate(),
                rooms: [{
                    id: 1,
                    adulti: $scope.internal.defaultAdults,
                    bambini: 0,
                    minAdulti: $scope.internal.minAdultsFirstRoom,
                    maxAdulti: $scope.internal.maxPeople,
                    minBambini: 0,
                    maxBambini: $scope.internal.maxPeople,
                }],
                ages: [],
            }

            $scope.submit = {
                hid: '',
                lang: 'IT',
                guests: '',
                in: moment(new Date()).startOf('day').format('YYYY-M-D'),
                out: moment(new Date()).startOf('day').add(parseInt($scope.internal.minNights), 'd').format('YYYY-M-D'),
                coupon: '',
            }

            $scope.$watch("form.arrivalDate", function(){
                $scope.internal.arrival = moment($scope.form.arrivalDate).startOf('day');
                $scope.internal.depart = moment($scope.form.departDate).startOf('day');
                $scope.internal.minDepartDate = moment($scope.internal.arrival.toDate()).add(parseInt($scope.internal.minNights), 'd').toDate();
                $scope.submit.in = $scope.internal.arrival.format('YYYY-M-D');
            }, true);

            $scope.$watch("form.departDate", function(){
                $scope.internal.arrival = moment($scope.form.arrivalDate).startOf('day');
                $scope.internal.depart = moment($scope.form.departDate).startOf('day');
                $scope.submit.out = $scope.internal.depart.format('YYYY-M-D');
            }, true);

            $scope.addRoom = function(){
                $scope.form.rooms.push({
                    id: _.last($scope.form.rooms).id+1,
                    adulti: $scope.internal.defaultAdults,
                    bambini: 0,
                    minAdulti: $scope.internal.minAdultsOtherRooms,
                    maxAdulti: $scope.internal.maxPeople,
                    minBambini: 0,
                    maxBambini: $scope.internal.maxPeople,
                });
            }

            $scope.removeRoom = function(){
                $scope.form.rooms.splice(-1,1);
            }

            $scope.submitForm = function(){
                $scope.submit.guests = '';
                _.forEach($scope.form.rooms, function(room){
                    for (var i = 0; i < room.adulti; i++) {
                        $scope.submit.guests += 'A,';                        
                    }
                    _.forEach($scope.form.ages, function(value, key){                        
                        _.forEach(value, function(value2, key2){
                            if ( key == room.id ) {
                                $scope.submit.guests += value2 + ',';
                            }
                        });
                    });
                    $scope.submit.guests = $scope.submit.guests.substring(0, $scope.submit.guests.length - 1);
                    $scope.submit.guests += '|';
                });
                $scope.submit.guests = $scope.submit.guests.substring(0, $scope.submit.guests.length - 1);

                $scope.internal.queryString = _.reduce($scope.submit, function(result, value, key) { return (!_.isNull(value) && !_.isUndefined(value)) ? (result += key + '=' + value + '&') : result; }, '').slice(0, -1);
                $window.open($scope.internal.url+'?'+$scope.internal.queryString);
            }
        }
    ]);
    
    app.filter('range', function() {
        return function(input, min, max) {
            min = parseInt(min);
            max = parseInt(max);
            for (var i=min; i<=max; i++)
                input.push(i);
            return input;
        };
    });

})( jQuery );