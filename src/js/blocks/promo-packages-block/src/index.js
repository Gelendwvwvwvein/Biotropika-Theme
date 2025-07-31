import { registerBlockType } from '@wordpress/blocks';
import ServerSideRender from '@wordpress/server-side-render';

registerBlockType('biotropika/promo-packages-block', {
  edit: () => <ServerSideRender block="biotropika/promo-packages-block" />,
  save: () => null,
});