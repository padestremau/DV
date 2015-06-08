<?php

namespace DV\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DVUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
