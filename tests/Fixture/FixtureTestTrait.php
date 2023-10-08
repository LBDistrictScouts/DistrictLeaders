<?php

namespace App\Test\Fixture;

trait FixtureTestTrait
{
    public function getFixtures(): array
    {
        return [
            'app.SiteSessions',

            'app.UserStates',
            'app.Users',
            'app.Capabilities',
            'app.ScoutGroups',
            'app.SectionTypes',
            'app.Sections',

            'app.RoleTemplates',
            'app.RoleTypes',
            'app.CapabilitiesRoleTypes',
            'app.RoleStatuses',

            'app.DirectoryTypes',
            'app.Directories',
            'app.DirectoryDomains',
            'app.DirectoryUsers',
            'app.DirectoryGroups',
            'app.RoleTypesDirectoryGroups',

            'app.UserContactTypes',
            'app.UserContacts',

            'app.Roles',
            'app.Audits',

            'app.NotificationTypes',
            'app.Notifications',

            'app.EmailSends',
            'app.Tokens',
            'app.EmailResponseTypes',
            'app.EmailResponses',

            'app.FileTypes',
            'app.DocumentTypes',
            'app.Documents',
            'app.DocumentVersions',
            'app.DocumentEditions',
            'app.CompassRecords',

            'app.CampTypes',
            'app.Camps',
            'app.CampRoleTypes',
            'app.CampRoles',

            'plugin.Queue.QueuedJobs',
            'plugin.Queue.QueueProcesses',
        ];
    }
}
