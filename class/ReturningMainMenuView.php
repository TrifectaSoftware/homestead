<?php

namespace Homestead;

define('FEATURE_LOCKED_ICON',   '<i class="fa fa-lock"></i>');
define('FEATURE_NOTYET_ICON',   '<i class="fa fa-calendar"></i>');
define('FEATURE_OPEN_ICON',     '<i class="fa fa-arrow-right"></i>');
define('FEATURE_COMPLETED_ICON','<i class="fa fa-check" title="Completed" alt="Completed"></i>');

class ReturningMainMenuView extends View {

    private $student;
    private $lotteryTerm;

    public function __construct(Student $student, $lotteryTerm)
    {
        $this->student		= $student;
        $this->lotteryTerm	= $lotteryTerm;
    }

    public function show()
    {
        $tpl = array();

        $termList = array();

        // Current term
        $currTerm = Term::getCurrentTerm();
        $termList[] = $currTerm; // Always add the current term

        // Find the next two summer terms (could be next year if Fall
        // is the current term, could be this year if Spring is current term)
        $summerTerm1 = $currTerm;
        while(Term::getTermSem($summerTerm1) != TERM_SUMMER1){
            $summerTerm1 = Term::getNextTerm($summerTerm1);
        }
        $summerTerm2 = Term::getNextTerm($summerTerm1);

        $currSem = Term::getTermSem($currTerm);
        if($currSem == TERM_SUMMER1){
            // If the current term is Summer 1, then we've already added it above,
            // so just add summer 2
            $termList[] = Term::getNextTerm($currTerm);
        }else if($currSem != TERM_SUMMER2){
            // Add both of the next summer terms then
            $termList[] = $summerTerm1;
            $termList[] = $summerTerm2;
        }


        // Re-application term
        if($this->lotteryTerm > $currTerm){
            // If the lottery term is in the future
            $termList[] = $this->lotteryTerm;
        }

        foreach($termList as $t){
            $termBlock = new StudentMenuTermBlock($this->student, $t);
            $tpl['TERMBLOCK'][] = array('TERMBLOCK_CONTENT'=>$termBlock->show());
        }

        \Layout::addPageTitle("Main Menu");

        return \PHPWS_Template::process($tpl, 'hms', 'student/returningMenu.tpl');
    }
}
