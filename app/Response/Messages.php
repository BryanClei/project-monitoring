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
    const INCORRECT_CREDENTIAL = "The provided credentials are incorrect.";

    //Not Found Message
    const TEAM_NOT_FOUND = "Team not found.";

    //Store Message
    const TEAM_SAVE = "Team created successfully.";

    //Patch/Put Message
    const TEAM_UPDATED = "Team updated successfully.";
    const TEAM_ARCHIVED = "Team archived successfully.";
    const TEAM_RESTORE = "Team restore successfully.";

    //Delete Message
    const TEAM_PERMANENTLY_DELETED = "Team permanently deleted successfully.";
}
