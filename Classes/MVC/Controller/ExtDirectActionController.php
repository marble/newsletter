<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2010 Dennis Ahrens <dennis.ahrens@fh-hannover.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 * A Controller used for answering via AJAX speaking JSON
 *
 * @package     Newsletter
 * @subpackage  MVC/Controller
 * @author      Dennis Ahrens <dennis.ahrens@fh-hannover.de>
 * @license     http://www.gnu.org/copyleft/gpl.html
 */
class Tx_Newsletter_MVC_Controller_ExtDirectActionController extends Tx_Extbase_MVC_Controller_ActionController
{

    /**
     * @var Tx_Extbase_Persistence_ManagerInterface
     * @inject
     */
    protected $persistenceManager;

    /**
     * Injects the PersistenceManager.
     *
     * @param Tx_Extbase_Persistence_ManagerInterface $persistenceManager
     * @return void
     */
    public function injectPersistenceManager(Tx_Extbase_Persistence_ManagerInterface $persistenceManager)
    {
        $this->persistenceManager = $persistenceManager;
    }

    /**
     * Initializes the View to be a Tx_Newsletter_ExtDirect_View that renders json without Template Files.
     *
     * @return void
     */
    public function initializeView()
    {
        if ($this->request->getFormat() === 'extdirect') {
            $this->view = $this->objectManager->create('Tx_Newsletter_MVC_View_ExtDirectView');
            $this->view->setControllerContext($this->controllerContext);
        }
    }

    /**
     * Override parent method to render error message for ExtJS (in JSON).
     * Also append detail about what property failed to error message.
     *
     * @author Adrien Crivelli
     * @return string
     */
    protected function errorAction()
    {
        $message = parent::errorAction();

        // Append detail of properties if available
        // Message layout is not optimal, but at least we avoid code duplication
        foreach ($this->argumentsMappingResults->getErrors() as $error) {
            if ($error instanceof Tx_Extbase_Validation_PropertyError) {
                foreach ($error->getErrors() as $subError) {
                    $message .= 'Error:   ' . $subError->getMessage() . PHP_EOL;
                }
            }
        }
        if ($this->view instanceof Tx_Newsletter_MVC_View_JsonView) {
            $this->view->setVariablesToRender(array('flashMessages', 'error', 'success'));
            $this->view->assign('flashMessages', $this->controllerContext->getFlashMessageQueue()->getAllMessagesAndFlush());
            $this->view->assign('error', $message);
            $this->view->assign('success', false);
        }
    }

}
