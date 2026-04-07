<?php

namespace App;

enum EmployeeRoleEnum: string
{
    case CREATE_JOB_OFFER = 'CREATE_JOB_OFFER';
    case HANDLE_APPLICATIONS = 'HANDLE_APPLICATIONS';
    case EDIT_COMPANY_DATA = 'EDIT_COMPANY_DATA';
}
