<?php
// @link https://confluence.jetbrains.com/display/PhpStorm/PhpStorm+Advanced+Metadata
namespace PHPSTORM_META {

	override(
		\Cake\Controller\Controller::loadComponent(0),
		map([
			'Ajax.Ajax' => \Ajax\Controller\Component\AjaxComponent::class,
			'Auth' => \Cake\Controller\Component\AuthComponent::class,
			'Authentication.Authentication' => \Authentication\Controller\Component\AuthenticationComponent::class,
			'Authorization.Authorization' => \Authorization\Controller\Component\AuthorizationComponent::class,
			'CapAuthorization' => \App\Controller\Component\CapAuthorizationComponent::class,
			'CloudConvertClient' => \App\Controller\Component\CloudConvertClientComponent::class,
			'Filter' => \App\Controller\Component\FilterComponent::class,
			'Flash' => \Cake\Controller\Component\FlashComponent::class,
			'Flash.Flash' => \Flash\Controller\Component\FlashComponent::class,
			'FormProtection' => \Cake\Controller\Component\FormProtectionComponent::class,
			'GoogleClient' => \App\Controller\Component\GoogleClientComponent::class,
			'Paginator' => \Cake\Controller\Component\PaginatorComponent::class,
			'RequestHandler' => \Cake\Controller\Component\RequestHandlerComponent::class,
			'Search.Search' => \Search\Controller\Component\SearchComponent::class,
			'Security' => \Cake\Controller\Component\SecurityComponent::class,
			'Tools.Common' => \Tools\Controller\Component\CommonComponent::class,
			'Tools.Mobile' => \Tools\Controller\Component\MobileComponent::class,
			'Tools.RefererRedirect' => \Tools\Controller\Component\RefererRedirectComponent::class,
			'Tools.Url' => \Tools\Controller\Component\UrlComponent::class,
		])
	);

	override(
		\Cake\Core\PluginApplicationInterface::addPlugin(0),
		map([
			'Ajax' => \Cake\Http\BaseApplication::class,
			'Authentication' => \Cake\Http\BaseApplication::class,
			'Authorization' => \Cake\Http\BaseApplication::class,
			'Bake' => \Cake\Http\BaseApplication::class,
			'BootstrapUI' => \Cake\Http\BaseApplication::class,
			'Cake/ElasticSearch' => \Cake\Http\BaseApplication::class,
			'CakeDto' => \Cake\Http\BaseApplication::class,
			'CakeImpersonate' => \Cake\Http\BaseApplication::class,
			'DatabaseLog' => \Cake\Http\BaseApplication::class,
			'DebugKit' => \Cake\Http\BaseApplication::class,
			'Flash' => \Cake\Http\BaseApplication::class,
			'IdeHelper' => \Cake\Http\BaseApplication::class,
			'Josbeir/Filesystem' => \Cake\Http\BaseApplication::class,
			'Migrations' => \Cake\Http\BaseApplication::class,
			'Muffin/Footprint' => \Cake\Http\BaseApplication::class,
			'Muffin/Trash' => \Cake\Http\BaseApplication::class,
			'Muffin/Webservice' => \Cake\Http\BaseApplication::class,
			'Queue' => \Cake\Http\BaseApplication::class,
			'Search' => \Cake\Http\BaseApplication::class,
			'Shim' => \Cake\Http\BaseApplication::class,
			'Tools' => \Cake\Http\BaseApplication::class,
			'WyriHaximus/TwigView' => \Cake\Http\BaseApplication::class,
		])
	);

	override(
		\Cake\Database\Type::build(0),
		map([
			'biginteger' => \Cake\Database\Type\IntegerType::class,
			'binary' => \Cake\Database\Type\BinaryType::class,
			'binaryuuid' => \Cake\Database\Type\BinaryUuidType::class,
			'boolean' => \Cake\Database\Type\BoolType::class,
			'char' => \Cake\Database\Type\StringType::class,
			'date' => \Cake\Database\Type\DateType::class,
			'datetime' => \Cake\Database\Type\DateTimeType::class,
			'datetimefractional' => \Cake\Database\Type\DateTimeFractionalType::class,
			'decimal' => \Cake\Database\Type\DecimalType::class,
			'float' => \Cake\Database\Type\FloatType::class,
			'integer' => \Cake\Database\Type\IntegerType::class,
			'json' => \Cake\Database\Type\JsonType::class,
			'smallinteger' => \Cake\Database\Type\IntegerType::class,
			'string' => \Cake\Database\Type\StringType::class,
			'text' => \Cake\Database\Type\StringType::class,
			'time' => \Cake\Database\Type\TimeType::class,
			'timestamp' => \Cake\Database\Type\DateTimeType::class,
			'timestampfractional' => \Cake\Database\Type\DateTimeFractionalType::class,
			'timestamptimezone' => \Cake\Database\Type\DateTimeTimezoneType::class,
			'tinyinteger' => \Cake\Database\Type\IntegerType::class,
			'uuid' => \Cake\Database\Type\UuidType::class,
		])
	);

	override(
		\Cake\Datasource\ModelAwareTrait::loadModel(0),
		map([
			'Audits' => \App\Model\Table\AuditsTable::class,
			'CampRoleTypes' => \App\Model\Table\CampRoleTypesTable::class,
			'CampRoles' => \App\Model\Table\CampRolesTable::class,
			'CampTypes' => \App\Model\Table\CampTypesTable::class,
			'Camps' => \App\Model\Table\CampsTable::class,
			'Capabilities' => \App\Model\Table\CapabilitiesTable::class,
			'CapabilitiesRoleTypes' => \App\Model\Table\CapabilitiesRoleTypesTable::class,
			'DatabaseLog.DatabaseLogApp' => \DatabaseLog\Model\Table\DatabaseLogAppTable::class,
			'DatabaseLog.DatabaseLogs' => \DatabaseLog\Model\Table\DatabaseLogsTable::class,
			'DebugKit.Panels' => \DebugKit\Model\Table\PanelsTable::class,
			'DebugKit.Requests' => \DebugKit\Model\Table\RequestsTable::class,
			'DocumentEditions' => \App\Model\Table\DocumentEditionsTable::class,
			'DocumentTypes' => \App\Model\Table\DocumentTypesTable::class,
			'DocumentVersions' => \App\Model\Table\DocumentVersionsTable::class,
			'Documents' => \App\Model\Table\DocumentsTable::class,
			'EmailResponseTypes' => \App\Model\Table\EmailResponseTypesTable::class,
			'EmailResponses' => \App\Model\Table\EmailResponsesTable::class,
			'EmailSends' => \App\Model\Table\EmailSendsTable::class,
			'FileTypes' => \App\Model\Table\FileTypesTable::class,
			'NotificationTypes' => \App\Model\Table\NotificationTypesTable::class,
			'Notifications' => \App\Model\Table\NotificationsTable::class,
			'Queue.QueueProcesses' => \Queue\Model\Table\QueueProcessesTable::class,
			'Queue.QueuedJobs' => \Queue\Model\Table\QueuedJobsTable::class,
			'RoleStatuses' => \App\Model\Table\RoleStatusesTable::class,
			'RoleTemplates' => \App\Model\Table\RoleTemplatesTable::class,
			'RoleTypes' => \App\Model\Table\RoleTypesTable::class,
			'Roles' => \App\Model\Table\RolesTable::class,
			'ScoutGroups' => \App\Model\Table\ScoutGroupsTable::class,
			'SectionTypes' => \App\Model\Table\SectionTypesTable::class,
			'Sections' => \App\Model\Table\SectionsTable::class,
			'SiteSessions' => \App\Model\Table\SiteSessionsTable::class,
			'Tokens' => \App\Model\Table\TokensTable::class,
			'Tools.Tokens' => \Tools\Model\Table\TokensTable::class,
			'UserContactTypes' => \App\Model\Table\UserContactTypesTable::class,
			'UserContacts' => \App\Model\Table\UserContactsTable::class,
			'UserStates' => \App\Model\Table\UserStatesTable::class,
			'Users' => \App\Model\Table\UsersTable::class,
		])
	);

	override(
		\Cake\Datasource\QueryInterface::find(0),
		map([
			'all' => \Cake\ORM\Query::class,
			'auth' => \Cake\ORM\Query::class,
			'documentList' => \Cake\ORM\Query::class,
			'list' => \Cake\ORM\Query::class,
			'onlyTrashed' => \Cake\ORM\Query::class,
			'queued' => \Cake\ORM\Query::class,
			'recent' => \Cake\ORM\Query::class,
			'search' => \Cake\ORM\Query::class,
			'threaded' => \Cake\ORM\Query::class,
			'withTrashed' => \Cake\ORM\Query::class,
		])
	);

	override(
		\Cake\ORM\Association::find(0),
		map([
			'all' => \Cake\ORM\Query::class,
			'auth' => \Cake\ORM\Query::class,
			'documentList' => \Cake\ORM\Query::class,
			'list' => \Cake\ORM\Query::class,
			'onlyTrashed' => \Cake\ORM\Query::class,
			'queued' => \Cake\ORM\Query::class,
			'recent' => \Cake\ORM\Query::class,
			'search' => \Cake\ORM\Query::class,
			'threaded' => \Cake\ORM\Query::class,
			'withTrashed' => \Cake\ORM\Query::class,
		])
	);

	override(
		\Cake\ORM\Locator\LocatorInterface::get(0),
		map([
			'Audits' => \App\Model\Table\AuditsTable::class,
			'CampRoleTypes' => \App\Model\Table\CampRoleTypesTable::class,
			'CampRoles' => \App\Model\Table\CampRolesTable::class,
			'CampTypes' => \App\Model\Table\CampTypesTable::class,
			'Camps' => \App\Model\Table\CampsTable::class,
			'Capabilities' => \App\Model\Table\CapabilitiesTable::class,
			'CapabilitiesRoleTypes' => \App\Model\Table\CapabilitiesRoleTypesTable::class,
			'DatabaseLog.DatabaseLogApp' => \DatabaseLog\Model\Table\DatabaseLogAppTable::class,
			'DatabaseLog.DatabaseLogs' => \DatabaseLog\Model\Table\DatabaseLogsTable::class,
			'DebugKit.Panels' => \DebugKit\Model\Table\PanelsTable::class,
			'DebugKit.Requests' => \DebugKit\Model\Table\RequestsTable::class,
			'DocumentEditions' => \App\Model\Table\DocumentEditionsTable::class,
			'DocumentTypes' => \App\Model\Table\DocumentTypesTable::class,
			'DocumentVersions' => \App\Model\Table\DocumentVersionsTable::class,
			'Documents' => \App\Model\Table\DocumentsTable::class,
			'EmailResponseTypes' => \App\Model\Table\EmailResponseTypesTable::class,
			'EmailResponses' => \App\Model\Table\EmailResponsesTable::class,
			'EmailSends' => \App\Model\Table\EmailSendsTable::class,
			'FileTypes' => \App\Model\Table\FileTypesTable::class,
			'NotificationTypes' => \App\Model\Table\NotificationTypesTable::class,
			'Notifications' => \App\Model\Table\NotificationsTable::class,
			'Queue.QueueProcesses' => \Queue\Model\Table\QueueProcessesTable::class,
			'Queue.QueuedJobs' => \Queue\Model\Table\QueuedJobsTable::class,
			'RoleStatuses' => \App\Model\Table\RoleStatusesTable::class,
			'RoleTemplates' => \App\Model\Table\RoleTemplatesTable::class,
			'RoleTypes' => \App\Model\Table\RoleTypesTable::class,
			'Roles' => \App\Model\Table\RolesTable::class,
			'ScoutGroups' => \App\Model\Table\ScoutGroupsTable::class,
			'SectionTypes' => \App\Model\Table\SectionTypesTable::class,
			'Sections' => \App\Model\Table\SectionsTable::class,
			'SiteSessions' => \App\Model\Table\SiteSessionsTable::class,
			'Tokens' => \App\Model\Table\TokensTable::class,
			'Tools.Tokens' => \Tools\Model\Table\TokensTable::class,
			'UserContactTypes' => \App\Model\Table\UserContactTypesTable::class,
			'UserContacts' => \App\Model\Table\UserContactsTable::class,
			'UserStates' => \App\Model\Table\UserStatesTable::class,
			'Users' => \App\Model\Table\UsersTable::class,
		])
	);

	override(
		\Cake\ORM\Table::addBehavior(0),
		map([
			'Auditable' => \Cake\ORM\Table::class,
			'Caseable' => \Cake\ORM\Table::class,
			'CounterCache' => \Cake\ORM\Table::class,
			'DebugKit.Timed' => \Cake\ORM\Table::class,
			'Muffin/Footprint.Footprint' => \Cake\ORM\Table::class,
			'Muffin/Trash.Trash' => \Cake\ORM\Table::class,
			'Search.Search' => \Cake\ORM\Table::class,
			'Timestamp' => \Cake\ORM\Table::class,
			'Tools.AfterSave' => \Cake\ORM\Table::class,
			'Tools.Bitmasked' => \Cake\ORM\Table::class,
			'Tools.Confirmable' => \Cake\ORM\Table::class,
			'Tools.Jsonable' => \Cake\ORM\Table::class,
			'Tools.Neighbor' => \Cake\ORM\Table::class,
			'Tools.Passwordable' => \Cake\ORM\Table::class,
			'Tools.Reset' => \Cake\ORM\Table::class,
			'Tools.Slugged' => \Cake\ORM\Table::class,
			'Tools.String' => \Cake\ORM\Table::class,
			'Tools.Toggle' => \Cake\ORM\Table::class,
			'Tools.TypeMap' => \Cake\ORM\Table::class,
			'Tools.Typographic' => \Cake\ORM\Table::class,
			'Translate' => \Cake\ORM\Table::class,
			'Tree' => \Cake\ORM\Table::class,
		])
	);

	override(
		\Cake\ORM\Table::belongToMany(0),
		map([
			'Audits' => \Cake\ORM\Association\BelongsToMany::class,
			'CampRoleTypes' => \Cake\ORM\Association\BelongsToMany::class,
			'CampRoles' => \Cake\ORM\Association\BelongsToMany::class,
			'CampTypes' => \Cake\ORM\Association\BelongsToMany::class,
			'Camps' => \Cake\ORM\Association\BelongsToMany::class,
			'Capabilities' => \Cake\ORM\Association\BelongsToMany::class,
			'CapabilitiesRoleTypes' => \Cake\ORM\Association\BelongsToMany::class,
			'DatabaseLog.DatabaseLogApp' => \Cake\ORM\Association\BelongsToMany::class,
			'DatabaseLog.DatabaseLogs' => \Cake\ORM\Association\BelongsToMany::class,
			'DebugKit.Panels' => \Cake\ORM\Association\BelongsToMany::class,
			'DebugKit.Requests' => \Cake\ORM\Association\BelongsToMany::class,
			'DocumentEditions' => \Cake\ORM\Association\BelongsToMany::class,
			'DocumentTypes' => \Cake\ORM\Association\BelongsToMany::class,
			'DocumentVersions' => \Cake\ORM\Association\BelongsToMany::class,
			'Documents' => \Cake\ORM\Association\BelongsToMany::class,
			'EmailResponseTypes' => \Cake\ORM\Association\BelongsToMany::class,
			'EmailResponses' => \Cake\ORM\Association\BelongsToMany::class,
			'EmailSends' => \Cake\ORM\Association\BelongsToMany::class,
			'FileTypes' => \Cake\ORM\Association\BelongsToMany::class,
			'NotificationTypes' => \Cake\ORM\Association\BelongsToMany::class,
			'Notifications' => \Cake\ORM\Association\BelongsToMany::class,
			'Queue.QueueProcesses' => \Cake\ORM\Association\BelongsToMany::class,
			'Queue.QueuedJobs' => \Cake\ORM\Association\BelongsToMany::class,
			'RoleStatuses' => \Cake\ORM\Association\BelongsToMany::class,
			'RoleTemplates' => \Cake\ORM\Association\BelongsToMany::class,
			'RoleTypes' => \Cake\ORM\Association\BelongsToMany::class,
			'Roles' => \Cake\ORM\Association\BelongsToMany::class,
			'ScoutGroups' => \Cake\ORM\Association\BelongsToMany::class,
			'SectionTypes' => \Cake\ORM\Association\BelongsToMany::class,
			'Sections' => \Cake\ORM\Association\BelongsToMany::class,
			'SiteSessions' => \Cake\ORM\Association\BelongsToMany::class,
			'Tokens' => \Cake\ORM\Association\BelongsToMany::class,
			'Tools.Tokens' => \Cake\ORM\Association\BelongsToMany::class,
			'UserContactTypes' => \Cake\ORM\Association\BelongsToMany::class,
			'UserContacts' => \Cake\ORM\Association\BelongsToMany::class,
			'UserStates' => \Cake\ORM\Association\BelongsToMany::class,
			'Users' => \Cake\ORM\Association\BelongsToMany::class,
		])
	);

	override(
		\Cake\ORM\Table::belongsTo(0),
		map([
			'Audits' => \Cake\ORM\Association\BelongsTo::class,
			'CampRoleTypes' => \Cake\ORM\Association\BelongsTo::class,
			'CampRoles' => \Cake\ORM\Association\BelongsTo::class,
			'CampTypes' => \Cake\ORM\Association\BelongsTo::class,
			'Camps' => \Cake\ORM\Association\BelongsTo::class,
			'Capabilities' => \Cake\ORM\Association\BelongsTo::class,
			'CapabilitiesRoleTypes' => \Cake\ORM\Association\BelongsTo::class,
			'DatabaseLog.DatabaseLogApp' => \Cake\ORM\Association\BelongsTo::class,
			'DatabaseLog.DatabaseLogs' => \Cake\ORM\Association\BelongsTo::class,
			'DebugKit.Panels' => \Cake\ORM\Association\BelongsTo::class,
			'DebugKit.Requests' => \Cake\ORM\Association\BelongsTo::class,
			'DocumentEditions' => \Cake\ORM\Association\BelongsTo::class,
			'DocumentTypes' => \Cake\ORM\Association\BelongsTo::class,
			'DocumentVersions' => \Cake\ORM\Association\BelongsTo::class,
			'Documents' => \Cake\ORM\Association\BelongsTo::class,
			'EmailResponseTypes' => \Cake\ORM\Association\BelongsTo::class,
			'EmailResponses' => \Cake\ORM\Association\BelongsTo::class,
			'EmailSends' => \Cake\ORM\Association\BelongsTo::class,
			'FileTypes' => \Cake\ORM\Association\BelongsTo::class,
			'NotificationTypes' => \Cake\ORM\Association\BelongsTo::class,
			'Notifications' => \Cake\ORM\Association\BelongsTo::class,
			'Queue.QueueProcesses' => \Cake\ORM\Association\BelongsTo::class,
			'Queue.QueuedJobs' => \Cake\ORM\Association\BelongsTo::class,
			'RoleStatuses' => \Cake\ORM\Association\BelongsTo::class,
			'RoleTemplates' => \Cake\ORM\Association\BelongsTo::class,
			'RoleTypes' => \Cake\ORM\Association\BelongsTo::class,
			'Roles' => \Cake\ORM\Association\BelongsTo::class,
			'ScoutGroups' => \Cake\ORM\Association\BelongsTo::class,
			'SectionTypes' => \Cake\ORM\Association\BelongsTo::class,
			'Sections' => \Cake\ORM\Association\BelongsTo::class,
			'SiteSessions' => \Cake\ORM\Association\BelongsTo::class,
			'Tokens' => \Cake\ORM\Association\BelongsTo::class,
			'Tools.Tokens' => \Cake\ORM\Association\BelongsTo::class,
			'UserContactTypes' => \Cake\ORM\Association\BelongsTo::class,
			'UserContacts' => \Cake\ORM\Association\BelongsTo::class,
			'UserStates' => \Cake\ORM\Association\BelongsTo::class,
			'Users' => \Cake\ORM\Association\BelongsTo::class,
		])
	);

	override(
		\Cake\ORM\Table::find(0),
		map([
			'all' => \Cake\ORM\Query::class,
			'auth' => \Cake\ORM\Query::class,
			'documentList' => \Cake\ORM\Query::class,
			'list' => \Cake\ORM\Query::class,
			'onlyTrashed' => \Cake\ORM\Query::class,
			'queued' => \Cake\ORM\Query::class,
			'recent' => \Cake\ORM\Query::class,
			'search' => \Cake\ORM\Query::class,
			'threaded' => \Cake\ORM\Query::class,
			'withTrashed' => \Cake\ORM\Query::class,
		])
	);

	override(
		\Cake\ORM\Table::hasMany(0),
		map([
			'Audits' => \Cake\ORM\Association\HasMany::class,
			'CampRoleTypes' => \Cake\ORM\Association\HasMany::class,
			'CampRoles' => \Cake\ORM\Association\HasMany::class,
			'CampTypes' => \Cake\ORM\Association\HasMany::class,
			'Camps' => \Cake\ORM\Association\HasMany::class,
			'Capabilities' => \Cake\ORM\Association\HasMany::class,
			'CapabilitiesRoleTypes' => \Cake\ORM\Association\HasMany::class,
			'DatabaseLog.DatabaseLogApp' => \Cake\ORM\Association\HasMany::class,
			'DatabaseLog.DatabaseLogs' => \Cake\ORM\Association\HasMany::class,
			'DebugKit.Panels' => \Cake\ORM\Association\HasMany::class,
			'DebugKit.Requests' => \Cake\ORM\Association\HasMany::class,
			'DocumentEditions' => \Cake\ORM\Association\HasMany::class,
			'DocumentTypes' => \Cake\ORM\Association\HasMany::class,
			'DocumentVersions' => \Cake\ORM\Association\HasMany::class,
			'Documents' => \Cake\ORM\Association\HasMany::class,
			'EmailResponseTypes' => \Cake\ORM\Association\HasMany::class,
			'EmailResponses' => \Cake\ORM\Association\HasMany::class,
			'EmailSends' => \Cake\ORM\Association\HasMany::class,
			'FileTypes' => \Cake\ORM\Association\HasMany::class,
			'NotificationTypes' => \Cake\ORM\Association\HasMany::class,
			'Notifications' => \Cake\ORM\Association\HasMany::class,
			'Queue.QueueProcesses' => \Cake\ORM\Association\HasMany::class,
			'Queue.QueuedJobs' => \Cake\ORM\Association\HasMany::class,
			'RoleStatuses' => \Cake\ORM\Association\HasMany::class,
			'RoleTemplates' => \Cake\ORM\Association\HasMany::class,
			'RoleTypes' => \Cake\ORM\Association\HasMany::class,
			'Roles' => \Cake\ORM\Association\HasMany::class,
			'ScoutGroups' => \Cake\ORM\Association\HasMany::class,
			'SectionTypes' => \Cake\ORM\Association\HasMany::class,
			'Sections' => \Cake\ORM\Association\HasMany::class,
			'SiteSessions' => \Cake\ORM\Association\HasMany::class,
			'Tokens' => \Cake\ORM\Association\HasMany::class,
			'Tools.Tokens' => \Cake\ORM\Association\HasMany::class,
			'UserContactTypes' => \Cake\ORM\Association\HasMany::class,
			'UserContacts' => \Cake\ORM\Association\HasMany::class,
			'UserStates' => \Cake\ORM\Association\HasMany::class,
			'Users' => \Cake\ORM\Association\HasMany::class,
		])
	);

	override(
		\Cake\ORM\Table::hasOne(0),
		map([
			'Audits' => \Cake\ORM\Association\HasOne::class,
			'CampRoleTypes' => \Cake\ORM\Association\HasOne::class,
			'CampRoles' => \Cake\ORM\Association\HasOne::class,
			'CampTypes' => \Cake\ORM\Association\HasOne::class,
			'Camps' => \Cake\ORM\Association\HasOne::class,
			'Capabilities' => \Cake\ORM\Association\HasOne::class,
			'CapabilitiesRoleTypes' => \Cake\ORM\Association\HasOne::class,
			'DatabaseLog.DatabaseLogApp' => \Cake\ORM\Association\HasOne::class,
			'DatabaseLog.DatabaseLogs' => \Cake\ORM\Association\HasOne::class,
			'DebugKit.Panels' => \Cake\ORM\Association\HasOne::class,
			'DebugKit.Requests' => \Cake\ORM\Association\HasOne::class,
			'DocumentEditions' => \Cake\ORM\Association\HasOne::class,
			'DocumentTypes' => \Cake\ORM\Association\HasOne::class,
			'DocumentVersions' => \Cake\ORM\Association\HasOne::class,
			'Documents' => \Cake\ORM\Association\HasOne::class,
			'EmailResponseTypes' => \Cake\ORM\Association\HasOne::class,
			'EmailResponses' => \Cake\ORM\Association\HasOne::class,
			'EmailSends' => \Cake\ORM\Association\HasOne::class,
			'FileTypes' => \Cake\ORM\Association\HasOne::class,
			'NotificationTypes' => \Cake\ORM\Association\HasOne::class,
			'Notifications' => \Cake\ORM\Association\HasOne::class,
			'Queue.QueueProcesses' => \Cake\ORM\Association\HasOne::class,
			'Queue.QueuedJobs' => \Cake\ORM\Association\HasOne::class,
			'RoleStatuses' => \Cake\ORM\Association\HasOne::class,
			'RoleTemplates' => \Cake\ORM\Association\HasOne::class,
			'RoleTypes' => \Cake\ORM\Association\HasOne::class,
			'Roles' => \Cake\ORM\Association\HasOne::class,
			'ScoutGroups' => \Cake\ORM\Association\HasOne::class,
			'SectionTypes' => \Cake\ORM\Association\HasOne::class,
			'Sections' => \Cake\ORM\Association\HasOne::class,
			'SiteSessions' => \Cake\ORM\Association\HasOne::class,
			'Tokens' => \Cake\ORM\Association\HasOne::class,
			'Tools.Tokens' => \Cake\ORM\Association\HasOne::class,
			'UserContactTypes' => \Cake\ORM\Association\HasOne::class,
			'UserContacts' => \Cake\ORM\Association\HasOne::class,
			'UserStates' => \Cake\ORM\Association\HasOne::class,
			'Users' => \Cake\ORM\Association\HasOne::class,
		])
	);

	override(
		\Cake\ORM\TableRegistry::get(0),
		map([
			'Audits' => \App\Model\Table\AuditsTable::class,
			'CampRoleTypes' => \App\Model\Table\CampRoleTypesTable::class,
			'CampRoles' => \App\Model\Table\CampRolesTable::class,
			'CampTypes' => \App\Model\Table\CampTypesTable::class,
			'Camps' => \App\Model\Table\CampsTable::class,
			'Capabilities' => \App\Model\Table\CapabilitiesTable::class,
			'CapabilitiesRoleTypes' => \App\Model\Table\CapabilitiesRoleTypesTable::class,
			'DatabaseLog.DatabaseLogApp' => \DatabaseLog\Model\Table\DatabaseLogAppTable::class,
			'DatabaseLog.DatabaseLogs' => \DatabaseLog\Model\Table\DatabaseLogsTable::class,
			'DebugKit.Panels' => \DebugKit\Model\Table\PanelsTable::class,
			'DebugKit.Requests' => \DebugKit\Model\Table\RequestsTable::class,
			'DocumentEditions' => \App\Model\Table\DocumentEditionsTable::class,
			'DocumentTypes' => \App\Model\Table\DocumentTypesTable::class,
			'DocumentVersions' => \App\Model\Table\DocumentVersionsTable::class,
			'Documents' => \App\Model\Table\DocumentsTable::class,
			'EmailResponseTypes' => \App\Model\Table\EmailResponseTypesTable::class,
			'EmailResponses' => \App\Model\Table\EmailResponsesTable::class,
			'EmailSends' => \App\Model\Table\EmailSendsTable::class,
			'FileTypes' => \App\Model\Table\FileTypesTable::class,
			'NotificationTypes' => \App\Model\Table\NotificationTypesTable::class,
			'Notifications' => \App\Model\Table\NotificationsTable::class,
			'Queue.QueueProcesses' => \Queue\Model\Table\QueueProcessesTable::class,
			'Queue.QueuedJobs' => \Queue\Model\Table\QueuedJobsTable::class,
			'RoleStatuses' => \App\Model\Table\RoleStatusesTable::class,
			'RoleTemplates' => \App\Model\Table\RoleTemplatesTable::class,
			'RoleTypes' => \App\Model\Table\RoleTypesTable::class,
			'Roles' => \App\Model\Table\RolesTable::class,
			'ScoutGroups' => \App\Model\Table\ScoutGroupsTable::class,
			'SectionTypes' => \App\Model\Table\SectionTypesTable::class,
			'Sections' => \App\Model\Table\SectionsTable::class,
			'SiteSessions' => \App\Model\Table\SiteSessionsTable::class,
			'Tokens' => \App\Model\Table\TokensTable::class,
			'Tools.Tokens' => \Tools\Model\Table\TokensTable::class,
			'UserContactTypes' => \App\Model\Table\UserContactTypesTable::class,
			'UserContacts' => \App\Model\Table\UserContactsTable::class,
			'UserStates' => \App\Model\Table\UserStatesTable::class,
			'Users' => \App\Model\Table\UsersTable::class,
		])
	);

	expectedArguments(
		\Cake\Routing\Router::pathUrl(),
		0,
		'Admin::action',
		'Audits::action',
		'CampRoleTypes::action',
		'CampRoles::action',
		'CampTypes::action',
		'Camps::action',
		'Capabilities::action',
		'Challenges::action',
		'DatabaseLog.DatabaseLog::action',
		'DatabaseLog.Logs::action',
		'DebugKit.Composer::action',
		'DebugKit.Dashboard::action',
		'DebugKit.DebugKit::action',
		'DebugKit.MailPreview::action',
		'DebugKit.Panels::action',
		'DebugKit.Requests::action',
		'DebugKit.Toolbar::action',
		'DocumentEditions::action',
		'DocumentTypes::action',
		'DocumentVersions::action',
		'Documents::action',
		'EmailResponseTypes::action',
		'EmailResponses::action',
		'EmailSends::action',
		'Error::action',
		'Issues::action',
		'NotificationTypes::action',
		'Notifications::action',
		'Pages::action',
		'Queue.Queue::action',
		'Queue.QueueProcesses::action',
		'Queue.QueuedJobs::action',
		'RoleStatuses::action',
		'RoleTemplates::action',
		'RoleTypes::action',
		'Roles::action',
		'ScoutGroups::action',
		'SectionTypes::action',
		'Sections::action',
		'Tokens::action',
		'Tools.ShuntRequest::action',
		'UserContactTypes::action',
		'UserContacts::action',
		'UserStates::action',
		'Users::action'
	);

	expectedArguments(
		\Cake\Validation\Validator::requirePresence(),
		1,
		'create',
		'update'
	);

	override(
		\Cake\View\View::element(0),
		map([
			'ActionMenu/begin' => \Cake\View\View::class,
			'ActionMenu/crud_item' => \Cake\View\View::class,
			'ActionMenu/edit_item' => \Cake\View\View::class,
			'ActionMenu/end' => \Cake\View\View::class,
			'ActionMenu/list' => \Cake\View\View::class,
			'ActionMenu/list_item' => \Cake\View\View::class,
			'BootstrapUI.flash/default' => \Cake\View\View::class,
			'DatabaseLog.paging' => \Cake\View\View::class,
			'DatabaseLog.search' => \Cake\View\View::class,
			'DebugKit.cache_panel' => \Cake\View\View::class,
			'DebugKit.deprecations_panel' => \Cake\View\View::class,
			'DebugKit.environment_panel' => \Cake\View\View::class,
			'DebugKit.history_panel' => \Cake\View\View::class,
			'DebugKit.include_panel' => \Cake\View\View::class,
			'DebugKit.log_panel' => \Cake\View\View::class,
			'DebugKit.mail_panel' => \Cake\View\View::class,
			'DebugKit.packages_panel' => \Cake\View\View::class,
			'DebugKit.preview_header' => \Cake\View\View::class,
			'DebugKit.request_panel' => \Cake\View\View::class,
			'DebugKit.routes_panel' => \Cake\View\View::class,
			'DebugKit.session_panel' => \Cake\View\View::class,
			'DebugKit.sql_log_panel' => \Cake\View\View::class,
			'DebugKit.timer_panel' => \Cake\View\View::class,
			'DebugKit.variables_panel' => \Cake\View\View::class,
			'ModuleNav/admin' => \Cake\View\View::class,
			'ModuleNav/directory' => \Cake\View\View::class,
			'ModuleNav/documents' => \Cake\View\View::class,
			'ModuleNav/groups' => \Cake\View\View::class,
			'ModuleNav/queue' => \Cake\View\View::class,
			'ModuleNav/selector' => \Cake\View\View::class,
			'Queue.search' => \Cake\View\View::class,
			'Related/entity' => \Cake\View\View::class,
			'Related/header' => \Cake\View\View::class,
			'Tools.pagination' => \Cake\View\View::class,
			'WyriHaximus/TwigView.twig_panel' => \Cake\View\View::class,
			'dark-footer' => \Cake\View\View::class,
			'flash/default' => \Cake\View\View::class,
			'flash/error' => \Cake\View\View::class,
			'flash/success' => \Cake\View\View::class,
			'footer' => \Cake\View\View::class,
			'header' => \Cake\View\View::class,
			'navbar' => \Cake\View\View::class,
			'script' => \Cake\View\View::class,
			'search' => \Cake\View\View::class,
			'style' => \Cake\View\View::class,
		])
	);

	override(
		\Cake\View\View::loadHelper(0),
		map([
			'Authentication.Identity' => \Authentication\View\Helper\IdentityHelper::class,
			'Bake.Bake' => \Bake\View\Helper\BakeHelper::class,
			'Bake.DocBlock' => \Bake\View\Helper\DocBlockHelper::class,
			'BootstrapUI.Breadcrumbs' => \BootstrapUI\View\Helper\BreadcrumbsHelper::class,
			'BootstrapUI.Flash' => \BootstrapUI\View\Helper\FlashHelper::class,
			'BootstrapUI.Form' => \BootstrapUI\View\Helper\FormHelper::class,
			'BootstrapUI.Html' => \BootstrapUI\View\Helper\HtmlHelper::class,
			'BootstrapUI.Paginator' => \BootstrapUI\View\Helper\PaginatorHelper::class,
			'Breadcrumbs' => \Cake\View\Helper\BreadcrumbsHelper::class,
			'CakeDto.Template' => \CakeDto\View\Helper\TemplateHelper::class,
			'CapIdentity' => \App\View\Helper\CapIdentityHelper::class,
			'DatabaseLog.Log' => \DatabaseLog\View\Helper\LogHelper::class,
			'DebugKit.Credentials' => \DebugKit\View\Helper\CredentialsHelper::class,
			'DebugKit.SimpleGraph' => \DebugKit\View\Helper\SimpleGraphHelper::class,
			'DebugKit.Toolbar' => \DebugKit\View\Helper\ToolbarHelper::class,
			'Flash' => \Cake\View\Helper\FlashHelper::class,
			'Flash.Flash' => \Flash\View\Helper\FlashHelper::class,
			'Form' => \Cake\View\Helper\FormHelper::class,
			'Functional' => \App\View\Helper\FunctionalHelper::class,
			'Html' => \Cake\View\Helper\HtmlHelper::class,
			'Icon' => \App\View\Helper\IconHelper::class,
			'IdeHelper.DocBlock' => \IdeHelper\View\Helper\DocBlockHelper::class,
			'Inflection' => \App\View\Helper\InflectionHelper::class,
			'Markdown' => \App\View\Helper\MarkdownHelper::class,
			'Migrations.Migration' => \Migrations\View\Helper\MigrationHelper::class,
			'Number' => \Cake\View\Helper\NumberHelper::class,
			'Paginator' => \Cake\View\Helper\PaginatorHelper::class,
			'Queue.Queue' => \Queue\View\Helper\QueueHelper::class,
			'Queue.QueueProgress' => \Queue\View\Helper\QueueProgressHelper::class,
			'Search.Search' => \Search\View\Helper\SearchHelper::class,
			'Text' => \Cake\View\Helper\TextHelper::class,
			'Time' => \Cake\View\Helper\TimeHelper::class,
			'Tools.Common' => \Tools\View\Helper\CommonHelper::class,
			'Tools.Form' => \Tools\View\Helper\FormHelper::class,
			'Tools.Format' => \Tools\View\Helper\FormatHelper::class,
			'Tools.Gravatar' => \Tools\View\Helper\GravatarHelper::class,
			'Tools.Html' => \Tools\View\Helper\HtmlHelper::class,
			'Tools.Meter' => \Tools\View\Helper\MeterHelper::class,
			'Tools.Number' => \Tools\View\Helper\NumberHelper::class,
			'Tools.Obfuscate' => \Tools\View\Helper\ObfuscateHelper::class,
			'Tools.Progress' => \Tools\View\Helper\ProgressHelper::class,
			'Tools.QrCode' => \Tools\View\Helper\QrCodeHelper::class,
			'Tools.Text' => \Tools\View\Helper\TextHelper::class,
			'Tools.Time' => \Tools\View\Helper\TimeHelper::class,
			'Tools.Timeline' => \Tools\View\Helper\TimelineHelper::class,
			'Tools.Tree' => \Tools\View\Helper\TreeHelper::class,
			'Tools.Typography' => \Tools\View\Helper\TypographyHelper::class,
			'Tools.Url' => \Tools\View\Helper\UrlHelper::class,
			'Url' => \Cake\View\Helper\UrlHelper::class,
		])
	);

	expectedArguments(
		\Queue\Model\Table\QueuedJobsTable::createJob(),
		0,
		'Capability',
		'CostsExample',
		'Email',
		'Example',
		'ExceptionExample',
		'Execute',
		'MailingList',
		'MonitorExample',
		'ProgressExample',
		'RetryExample',
		'SuperExample',
		'UniqueExample'
	);

	expectedArguments(
		\Queue\Model\Table\QueuedJobsTable::isQueued(),
		1,
		'Capability',
		'CostsExample',
		'Email',
		'Example',
		'ExceptionExample',
		'Execute',
		'MailingList',
		'MonitorExample',
		'ProgressExample',
		'RetryExample',
		'SuperExample',
		'UniqueExample'
	);

}
