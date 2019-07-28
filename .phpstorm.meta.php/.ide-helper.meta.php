<?php
// @link https://confluence.jetbrains.com/display/PhpStorm/PhpStorm+Advanced+Metadata
namespace PHPSTORM_META {

	override(
		\Cake\Controller\Controller::loadComponent(0),
		map([
			'Auth' => \Cake\Controller\Component\AuthComponent::class,
			'Cookie' => \Cake\Controller\Component\CookieComponent::class,
			'Csrf' => \Cake\Controller\Component\CsrfComponent::class,
			'Flash' => \Cake\Controller\Component\FlashComponent::class,
			'Paginator' => \Cake\Controller\Component\PaginatorComponent::class,
			'RequestHandler' => \Cake\Controller\Component\RequestHandlerComponent::class,
			'Security' => \Cake\Controller\Component\SecurityComponent::class,
			'CloudConvertClient' => \App\Controller\Component\CloudConvertClientComponent::class,
			'GoogleClient' => \App\Controller\Component\GoogleClientComponent::class,
			'Authentication.Authentication' => \Authentication\Controller\Component\AuthenticationComponent::class,
			'Authorization.Authorization' => \Authorization\Controller\Component\AuthorizationComponent::class,
			'DebugKit.Toolbar' => \DebugKit\Controller\Component\ToolbarComponent::class,
		])
	);

	override(
		\Cake\Core\PluginApplicationInterface::addPlugin(0),
		map([
			'Authentication' => \Cake\Http\BaseApplication::class,
			'Authorization' => \Cake\Http\BaseApplication::class,
			'Bake' => \Cake\Http\BaseApplication::class,
			'BootstrapUI' => \Cake\Http\BaseApplication::class,
			'DatabaseLog' => \Cake\Http\BaseApplication::class,
			'DebugKit' => \Cake\Http\BaseApplication::class,
			'IdeHelper' => \Cake\Http\BaseApplication::class,
			'Josbeir/Filesystem' => \Cake\Http\BaseApplication::class,
			'Migrations' => \Cake\Http\BaseApplication::class,
			'Muffin/Footprint' => \Cake\Http\BaseApplication::class,
			'Muffin/Tokenize' => \Cake\Http\BaseApplication::class,
			'Muffin/Trash' => \Cake\Http\BaseApplication::class,
			'Search' => \Cake\Http\BaseApplication::class,
			'WyriHaximus/TwigView' => \Cake\Http\BaseApplication::class,
			'Xety/Cake3CookieAuth' => \Cake\Http\BaseApplication::class,
		])
	);

	override(
		\Cake\Database\Type::build(0),
		map([
			'biginteger' => \Cake\Database\Type\IntegerType::class,
			'binary' => \Cake\Database\Type\BinaryType::class,
			'binaryuuid' => \Cake\Database\Type\BinaryUuidType::class,
			'boolean' => \Cake\Database\Type\BoolType::class,
			'date' => \Cake\Database\Type\DateType::class,
			'datetime' => \Cake\Database\Type\DateTimeType::class,
			'decimal' => \Cake\Database\Type\DecimalType::class,
			'float' => \Cake\Database\Type\FloatType::class,
			'integer' => \Cake\Database\Type\IntegerType::class,
			'json' => \Cake\Database\Type\JsonType::class,
			'smallinteger' => \Cake\Database\Type\IntegerType::class,
			'string' => \Cake\Database\Type\StringType::class,
			'text' => \Cake\Database\Type\StringType::class,
			'time' => \Cake\Database\Type\TimeType::class,
			'timestamp' => \Cake\Database\Type\DateTimeType::class,
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
			'RoleStatuses' => \App\Model\Table\RoleStatusesTable::class,
			'RoleTypes' => \App\Model\Table\RoleTypesTable::class,
			'Roles' => \App\Model\Table\RolesTable::class,
			'ScoutGroups' => \App\Model\Table\ScoutGroupsTable::class,
			'SectionTypes' => \App\Model\Table\SectionTypesTable::class,
			'Sections' => \App\Model\Table\SectionsTable::class,
			'SiteSessions' => \App\Model\Table\SiteSessionsTable::class,
			'Users' => \App\Model\Table\UsersTable::class,
			'DatabaseLog.DatabaseLogApp' => \DatabaseLog\Model\Table\DatabaseLogAppTable::class,
			'DatabaseLog.DatabaseLogs' => \DatabaseLog\Model\Table\DatabaseLogsTable::class,
			'DebugKit.Panels' => \DebugKit\Model\Table\PanelsTable::class,
			'DebugKit.Requests' => \DebugKit\Model\Table\RequestsTable::class,
			'Muffin/Tokenize.Tokens' => \Muffin\Tokenize\Model\Table\TokensTable::class,
		])
	);

	override(
		\Cake\Datasource\QueryInterface::find(0),
		map([
			'all' => \Cake\ORM\Query::class,
			'list' => \Cake\ORM\Query::class,
			'threaded' => \Cake\ORM\Query::class,
			'users' => \Cake\ORM\Query::class,
			'onlytrashed' => \Cake\ORM\Query::class,
			'withtrashed' => \Cake\ORM\Query::class,
			'auth' => \Cake\ORM\Query::class,
			'recent' => \Cake\ORM\Query::class,
			'token' => \Cake\ORM\Query::class,
		])
	);

	override(
		\Cake\ORM\Association::find(0),
		map([
			'all' => \Cake\ORM\Query::class,
			'list' => \Cake\ORM\Query::class,
			'threaded' => \Cake\ORM\Query::class,
			'users' => \Cake\ORM\Query::class,
			'onlytrashed' => \Cake\ORM\Query::class,
			'withtrashed' => \Cake\ORM\Query::class,
			'auth' => \Cake\ORM\Query::class,
			'recent' => \Cake\ORM\Query::class,
			'token' => \Cake\ORM\Query::class,
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
			'RoleStatuses' => \App\Model\Table\RoleStatusesTable::class,
			'RoleTypes' => \App\Model\Table\RoleTypesTable::class,
			'Roles' => \App\Model\Table\RolesTable::class,
			'ScoutGroups' => \App\Model\Table\ScoutGroupsTable::class,
			'SectionTypes' => \App\Model\Table\SectionTypesTable::class,
			'Sections' => \App\Model\Table\SectionsTable::class,
			'SiteSessions' => \App\Model\Table\SiteSessionsTable::class,
			'Users' => \App\Model\Table\UsersTable::class,
			'DatabaseLog.DatabaseLogApp' => \DatabaseLog\Model\Table\DatabaseLogAppTable::class,
			'DatabaseLog.DatabaseLogs' => \DatabaseLog\Model\Table\DatabaseLogsTable::class,
			'DebugKit.Panels' => \DebugKit\Model\Table\PanelsTable::class,
			'DebugKit.Requests' => \DebugKit\Model\Table\RequestsTable::class,
			'Muffin/Tokenize.Tokens' => \Muffin\Tokenize\Model\Table\TokensTable::class,
		])
	);

	override(
		\Cake\ORM\Table::addBehavior(0),
		map([
			'CounterCache' => \Cake\ORM\Table::class,
			'DebugKit.Timed' => \Cake\ORM\Table::class,
			'Muffin/Footprint.Footprint' => \Cake\ORM\Table::class,
			'Muffin/Tokenize.Tokenize' => \Cake\ORM\Table::class,
			'Muffin/Trash.Trash' => \Cake\ORM\Table::class,
			'Timestamp' => \Cake\ORM\Table::class,
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
			'RoleStatuses' => \Cake\ORM\Association\BelongsToMany::class,
			'RoleTypes' => \Cake\ORM\Association\BelongsToMany::class,
			'Roles' => \Cake\ORM\Association\BelongsToMany::class,
			'ScoutGroups' => \Cake\ORM\Association\BelongsToMany::class,
			'SectionTypes' => \Cake\ORM\Association\BelongsToMany::class,
			'Sections' => \Cake\ORM\Association\BelongsToMany::class,
			'SiteSessions' => \Cake\ORM\Association\BelongsToMany::class,
			'Users' => \Cake\ORM\Association\BelongsToMany::class,
			'DatabaseLog.DatabaseLogApp' => \Cake\ORM\Association\BelongsToMany::class,
			'DatabaseLog.DatabaseLogs' => \Cake\ORM\Association\BelongsToMany::class,
			'DebugKit.Panels' => \Cake\ORM\Association\BelongsToMany::class,
			'DebugKit.Requests' => \Cake\ORM\Association\BelongsToMany::class,
			'Muffin/Tokenize.Tokens' => \Cake\ORM\Association\BelongsToMany::class,
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
			'RoleStatuses' => \Cake\ORM\Association\BelongsTo::class,
			'RoleTypes' => \Cake\ORM\Association\BelongsTo::class,
			'Roles' => \Cake\ORM\Association\BelongsTo::class,
			'ScoutGroups' => \Cake\ORM\Association\BelongsTo::class,
			'SectionTypes' => \Cake\ORM\Association\BelongsTo::class,
			'Sections' => \Cake\ORM\Association\BelongsTo::class,
			'SiteSessions' => \Cake\ORM\Association\BelongsTo::class,
			'Users' => \Cake\ORM\Association\BelongsTo::class,
			'DatabaseLog.DatabaseLogApp' => \Cake\ORM\Association\BelongsTo::class,
			'DatabaseLog.DatabaseLogs' => \Cake\ORM\Association\BelongsTo::class,
			'DebugKit.Panels' => \Cake\ORM\Association\BelongsTo::class,
			'DebugKit.Requests' => \Cake\ORM\Association\BelongsTo::class,
			'Muffin/Tokenize.Tokens' => \Cake\ORM\Association\BelongsTo::class,
		])
	);

	override(
		\Cake\ORM\Table::find(0),
		map([
			'all' => \Cake\ORM\Query::class,
			'list' => \Cake\ORM\Query::class,
			'threaded' => \Cake\ORM\Query::class,
			'users' => \Cake\ORM\Query::class,
			'onlytrashed' => \Cake\ORM\Query::class,
			'withtrashed' => \Cake\ORM\Query::class,
			'auth' => \Cake\ORM\Query::class,
			'recent' => \Cake\ORM\Query::class,
			'token' => \Cake\ORM\Query::class,
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
			'RoleStatuses' => \Cake\ORM\Association\HasMany::class,
			'RoleTypes' => \Cake\ORM\Association\HasMany::class,
			'Roles' => \Cake\ORM\Association\HasMany::class,
			'ScoutGroups' => \Cake\ORM\Association\HasMany::class,
			'SectionTypes' => \Cake\ORM\Association\HasMany::class,
			'Sections' => \Cake\ORM\Association\HasMany::class,
			'SiteSessions' => \Cake\ORM\Association\HasMany::class,
			'Users' => \Cake\ORM\Association\HasMany::class,
			'DatabaseLog.DatabaseLogApp' => \Cake\ORM\Association\HasMany::class,
			'DatabaseLog.DatabaseLogs' => \Cake\ORM\Association\HasMany::class,
			'DebugKit.Panels' => \Cake\ORM\Association\HasMany::class,
			'DebugKit.Requests' => \Cake\ORM\Association\HasMany::class,
			'Muffin/Tokenize.Tokens' => \Cake\ORM\Association\HasMany::class,
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
			'RoleStatuses' => \Cake\ORM\Association\HasOne::class,
			'RoleTypes' => \Cake\ORM\Association\HasOne::class,
			'Roles' => \Cake\ORM\Association\HasOne::class,
			'ScoutGroups' => \Cake\ORM\Association\HasOne::class,
			'SectionTypes' => \Cake\ORM\Association\HasOne::class,
			'Sections' => \Cake\ORM\Association\HasOne::class,
			'SiteSessions' => \Cake\ORM\Association\HasOne::class,
			'Users' => \Cake\ORM\Association\HasOne::class,
			'DatabaseLog.DatabaseLogApp' => \Cake\ORM\Association\HasOne::class,
			'DatabaseLog.DatabaseLogs' => \Cake\ORM\Association\HasOne::class,
			'DebugKit.Panels' => \Cake\ORM\Association\HasOne::class,
			'DebugKit.Requests' => \Cake\ORM\Association\HasOne::class,
			'Muffin/Tokenize.Tokens' => \Cake\ORM\Association\HasOne::class,
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
			'RoleStatuses' => \App\Model\Table\RoleStatusesTable::class,
			'RoleTypes' => \App\Model\Table\RoleTypesTable::class,
			'Roles' => \App\Model\Table\RolesTable::class,
			'ScoutGroups' => \App\Model\Table\ScoutGroupsTable::class,
			'SectionTypes' => \App\Model\Table\SectionTypesTable::class,
			'Sections' => \App\Model\Table\SectionsTable::class,
			'SiteSessions' => \App\Model\Table\SiteSessionsTable::class,
			'Users' => \App\Model\Table\UsersTable::class,
			'DatabaseLog.DatabaseLogApp' => \DatabaseLog\Model\Table\DatabaseLogAppTable::class,
			'DatabaseLog.DatabaseLogs' => \DatabaseLog\Model\Table\DatabaseLogsTable::class,
			'DebugKit.Panels' => \DebugKit\Model\Table\PanelsTable::class,
			'DebugKit.Requests' => \DebugKit\Model\Table\RequestsTable::class,
			'Muffin/Tokenize.Tokens' => \Muffin\Tokenize\Model\Table\TokensTable::class,
		])
	);

	override(
		\Cake\View\View::element(0),
		map([
			'BootstrapUI.Flash/default' => \Cake\View\View::class,
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
			'Flash/default' => \Cake\View\View::class,
			'Flash/error' => \Cake\View\View::class,
			'Flash/success' => \Cake\View\View::class,
			'WyriHaximus/TwigView.twig_panel' => \Cake\View\View::class,
			'footer' => \Cake\View\View::class,
			'header' => \Cake\View\View::class,
			'navbar' => \Cake\View\View::class,
			'script' => \Cake\View\View::class,
			'style' => \Cake\View\View::class,
		])
	);

	override(
		\Cake\View\View::loadHelper(0),
		map([
			'Breadcrumbs' => \Cake\View\Helper\BreadcrumbsHelper::class,
			'Flash' => \Cake\View\Helper\FlashHelper::class,
			'Form' => \Cake\View\Helper\FormHelper::class,
			'Html' => \Cake\View\Helper\HtmlHelper::class,
			'Number' => \Cake\View\Helper\NumberHelper::class,
			'Paginator' => \Cake\View\Helper\PaginatorHelper::class,
			'Rss' => \Cake\View\Helper\RssHelper::class,
			'Session' => \Cake\View\Helper\SessionHelper::class,
			'Text' => \Cake\View\Helper\TextHelper::class,
			'Time' => \Cake\View\Helper\TimeHelper::class,
			'Url' => \Cake\View\Helper\UrlHelper::class,
			'Functional' => \App\View\Helper\FunctionalHelper::class,
			'Icon' => \App\View\Helper\IconHelper::class,
			'Inflection' => \App\View\Helper\InflectionHelper::class,
			'Authentication.Identity' => \Authentication\View\Helper\IdentityHelper::class,
			'Bake.Bake' => \Bake\View\Helper\BakeHelper::class,
			'Bake.DocBlock' => \Bake\View\Helper\DocBlockHelper::class,
			'BootstrapUI.Breadcrumbs' => \BootstrapUI\View\Helper\BreadcrumbsHelper::class,
			'BootstrapUI.Flash' => \BootstrapUI\View\Helper\FlashHelper::class,
			'BootstrapUI.Form' => \BootstrapUI\View\Helper\FormHelper::class,
			'BootstrapUI.Html' => \BootstrapUI\View\Helper\HtmlHelper::class,
			'BootstrapUI.Paginator' => \BootstrapUI\View\Helper\PaginatorHelper::class,
			'DatabaseLog.Log' => \DatabaseLog\View\Helper\LogHelper::class,
			'DebugKit.Credentials' => \DebugKit\View\Helper\CredentialsHelper::class,
			'DebugKit.SimpleGraph' => \DebugKit\View\Helper\SimpleGraphHelper::class,
			'DebugKit.Tidy' => \DebugKit\View\Helper\TidyHelper::class,
			'DebugKit.Toolbar' => \DebugKit\View\Helper\ToolbarHelper::class,
			'IdeHelper.DocBlock' => \IdeHelper\View\Helper\DocBlockHelper::class,
			'Migrations.Migration' => \Migrations\View\Helper\MigrationHelper::class,
		])
	);

}