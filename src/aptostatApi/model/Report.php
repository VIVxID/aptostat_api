<?php

namespace aptostatApi\model;

class Report
{
    public function modifyFlag($id, $flagId)
    {
        // Check if ids are numbers and flagId is a number between 1-6
        if (!preg_match('/^\d+$/',$id) or !preg_match('/^\d+$/',$flagId)) {
            return 400; // Bad request
        }

        // Check if report exists
        $check = \ReportQuery::create()->findPK($id);
        if ($check == null) {
            return 404;
        }

        // Prepare statement
        $query = new \ReportStatus();
        $query->setIdReport($id);
        $query->setTimestamp(time());
        $query->setIdFlag($flagId);

        // Execute statement
        $query->save();

        return 200; // Ok
    }
}
