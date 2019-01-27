/* eslint-disable */

import labels from '../../includes/fc-labels';
import cols from '../../includes/fc-cols';
import hideField from '../../includes/fc-hidefield';
import singleText from '../../includes/fc-singletext';
import prePopInfo from '../../includes/fc-prepopinfo';
import prePopField from '../../includes/fc-prepopfield';

window.FormCraftApp.controller('DpiPrePopController', ['$scope', function($scope) {

    $scope.$watchCollection('Addons', function() {

        if (typeof $scope.$parent.Addons !== 'undefined' && typeof $scope.$parent.addField !== 'undefined') {

            const optionTemplate = prePopInfo + labels + cols + singleText + hideField;

            const fields = [
                {
                    name: 'Church ID',
                    fieldHTMLTemplate: prePopField,
                    fieldOptionTemplate: optionTemplate,
                    defaults: {
                        main_label: 'Church ID',
                        sub_label: '',
                        prePopType: 'CHURCH_ID'
                    }
                },
                {
                    name: 'Church Name',
                    fieldHTMLTemplate: prePopField,
                    fieldOptionTemplate: optionTemplate,
                    defaults: {
                        main_label: 'Church Name',
                        sub_label: '',
                        prePopType: 'CHURCH_NAME'
                    }
                },
                {
                    name: 'Church Phone',
                    fieldHTMLTemplate: prePopField,
                    fieldOptionTemplate: optionTemplate,
                    defaults: {
                        main_label: 'Church Phone',
                        sub_label: '',
                        prePopType: 'CHURCH_PHONE'
                    }
                },
                {
                    name: 'Church Street',
                    fieldHTMLTemplate: prePopField,
                    fieldOptionTemplate: optionTemplate,
                    defaults: {
                        main_label: 'Church Street',
                        sub_label: '',
                        prePopType: 'CHURCH_STREET'
                    }
                },
                {
                    name: 'Church City',
                    fieldHTMLTemplate: prePopField,
                    fieldOptionTemplate: optionTemplate,
                    defaults: {
                        main_label: 'Church City',
                        sub_label: '',
                        prePopType: 'CHURCH_CITY'
                    }
                },
                {
                    name: 'Church State',
                    fieldHTMLTemplate: prePopField,
                    fieldOptionTemplate: optionTemplate,
                    defaults: {
                        main_label: 'Church State',
                        sub_label: '',
                        prePopType: 'CHURCH_STATE'
                    }
                },
                {
                    name: 'Church ZIP',
                    fieldHTMLTemplate: prePopField,
                    fieldOptionTemplate: optionTemplate,
                    defaults: {
                        main_label: 'Church ZIP',
                        sub_label: '',
                        prePopType: 'CHURCH_ZIP'
                    }
                },
                {
                    name: 'Church Address',
                    fieldHTMLTemplate: prePopField,
                    fieldOptionTemplate: optionTemplate,
                    defaults: {
                        main_label: 'Church Address',
                        sub_label: '',
                        prePopType: 'CHURCH_ADDRESS'
                    }
                },
                {
                    name: 'Bulletin ID',
                    fieldHTMLTemplate: prePopField,
                    fieldOptionTemplate: optionTemplate,
                    defaults: {
                        main_label: 'Bulletin ID',
                        sub_label: '',
                        prePopType: 'BULLETIN_ID'
                    }
                },
                {
                    name: 'User Name',
                    fieldHTMLTemplate: prePopField,
                    fieldOptionTemplate: optionTemplate,
                    defaults: {
                        main_label: 'User Name',
                        sub_label: '',
                        prePopType: 'USER_NAME'
                    }
                },
                {
                    name: 'User Email',
                    fieldHTMLTemplate: prePopField,
                    fieldOptionTemplate: optionTemplate,
                    defaults: {
                        main_label: 'User Email',
                        sub_label: '',
                        prePopType: 'USER_EMAIL'
                    }
                }
            ];

            const others = $scope.$parent.addField.others.map(field => field.name);

            fields.forEach(field => {
                if (others.indexOf(field.name) === -1) {
                    $scope.$parent.addField.others.push(field);
                }
            });

        }
    });

}]);