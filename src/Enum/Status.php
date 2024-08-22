<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\PayboxDirect\Enum;

use Greg0ire\Enum\AbstractEnum;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Status extends AbstractEnum
{
    public const NOT_FOUND = 'Transaction non trouvée';

    public const REFUNDED = 'Remboursé';

    public const CANCELED = 'Annulé';

    public const AUTHORIZED = 'Autorisé';

    public const CAPTURED = 'Capturé';

    public const CREDIT = 'Crédit';

    public const REFUSED = 'Refusé';

    public const BALANCE_INQUIRY = 'Demande de solde (Carte cadeaux)';

    public const SUPPORT_REJECTION = 'Rejet support';
}
