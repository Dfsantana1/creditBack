<?php
declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class ScopesTrait
 *
 * @category Request
 * @package  App\Traits

 */
trait ScopesTrait
{

    //------------------------------------------------------
    // SCOPES JOIN Questions
    //------------------------------------------------------


    /**
     * Scope a query to join Responses
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeJoinQuestionResponse(Builder $query): Builder
    {
        return $query->join('responses', 'questionAnalytics.questionId', 'responses.questionId')
            ->whereNull('responses.deletedAt');

    }//end scopeJoinQuestionResponse()


    /**
     * Scope a query to join FormFieldset Group
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeJoinFormFieldsetGroup(Builder $query): Builder
    {
        return $query->join('formFieldsetGroups', 'formFieldsetGroups.formFieldsetId', 'formFieldset.id');

    }//end scopeJoinFormFieldsetGroup()


    /**
     * Scope a query to join FormFieldset Group Responses
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeJoinFormFieldsetGroupResponses(Builder $query): Builder
    {
        return $query->join('formFieldsetGroupResponses', 'formFieldsetGroupResponses.id', 'responses.formFieldsetGroupResponseId')
            ->whereNull('formFieldsetGroupResponses.deletedAt');

    }//end scopeJoinFormFieldsetGroupResponses()


    /**
     * Scope a query to join Users
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeJoinUsers(Builder $query): Builder
    {
        return $query->join('users', 'formFieldsetGroupResponses.userId', 'users.id')
            ->whereNull('users.deletedAt');

    }//end scopeJoinUsers()


    /**
     * Scope a query to join Users Profile
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeJoinUserProfiles(Builder $query): Builder
    {
        return $query->join('userProfiles', 'userProfiles.userId', 'users.id')
            ->whereNull('userProfiles.archivedAt');

    }//end scopeJoinUserProfiles()


    /**
     * Scope a query to join UserRoles
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeJoinUserRoles(Builder $query): Builder
    {
        return $query->join('userRoles', 'userRoles.userId', 'users.id')
            ->whereNull('userRoles.deletedAt');

    }//end scopeJoinUserRoles()



    //------------------------------------------------------
    // SCOPES JOIN Assessments
    //------------------------------------------------------
    /**
     * Scope a query to join Users
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeJoinUsersRoles(Builder $query): Builder
    {
        return $query->join('users', 'userRoles.userId', 'users.id')
            ->whereNull('users.deletedAt');

    }//end scopeJoinUsersRoles()
}
