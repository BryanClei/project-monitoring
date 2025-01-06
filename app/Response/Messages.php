<?php

namespace App\Response;

class Messages
{
    //STATUS CODES
    const CREATED_STATUS = 201;
    const UNPROCESS_STATUS = 422;
    const DATA_NOT_FOUND = 404;
    const SUCESS_STATUS = 200;
    const DENIED_STATUS = 403;

    //Error Message
    const INCORRECT_CREDENTIALS = "The provided credentials are incorrect.";

    //Not Found Message
    const TEAM_NOT_FOUND = "Team not found.";
    const NO_DATA_FOUND = "No data found.";
    const USER_NOT_FOUND = "User not found.";
    const NO_DATA_TO_DISPLAY = "No data to display.";

    //Store Message
    const TEAM_SAVE = "Team created successfully.";
    const ROLE_SAVE = "Role created successfully.";
    const USER_SAVE = "User created successfully.";
    const PROJECT_SAVE = "Project created successfully.";
    const MONITORING_SAVE = "Monitoring created successfully.";
    const USER_SYSTEM_SAVE = "Tagged system successfully.";

    //Patch/Put Message
    const TEAM_UPDATED = "Team updated successfully.";
    const TEAM_ARCHIVED = "Team archived successfully.";
    const TEAM_RESTORE = "Team restore successfully.";
    const ROLE_UPDATED = "Role updated successfully.";
    const ROLE_ARCHIVED = "Role archived successfully.";
    const ROLE_RESTORE = "Role restore successfully.";
    const PROJECT_ARCHIVED = "Project archived successfully";
    const PROJECT_RESTORE = "Project restored successfully.";
    const PROJECT_UPDATED = "Project updated successfully.";
    const MONITORING_UPDATED = "Monitoring updated successfully.";
    const MONITORING_ARCHIVED = "Monitoring archived successfully.";
    const MONITORING_RESTORED = "Monitoring restore successfully.";

    //Delete Message
    const TEAM_PERMANENTLY_DELETED = "Team permanently deleted successfully.";

    //Display Message
    const TEAM_DISPLAY = "Team display successfully.";
    const USER_DISPLAY = "User display successfully.";
    const ROLE_DISPLAY = "Role display successfully.";
    const PROJECT_DISPLAY = "Project display successfully.";
    const MONITORING_DISPLAY = "Monitoring display successfully.";
    const LOGIN_USER = "Successfully login, Fresh Morning.";
    const ARCHIVE_STATUS = "Archived successfully.";
    const RESTORE_STATUS = "Restore successfully.";
}
