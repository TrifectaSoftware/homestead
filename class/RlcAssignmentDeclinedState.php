<?php

namespace Homestead;

/**
 * RlcAssignmentDeclinedState
 *
 * Represtents the state of a RLC assignment when the student has declined the invitation.
 *
 * @author jbooker
 * @package HMS
 */
class RlcAssignmentDeclinedState extends RlcAssignmentState {

    protected $stateName = 'declined';

    public function onEnter()
    {

    }
}
