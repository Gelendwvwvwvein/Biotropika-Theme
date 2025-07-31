import { registerBlockType } from '@wordpress/blocks';
import Edit from './editor';
import '../style/editor.scss';
import '../style/frontend.scss';

registerBlockType('biotropika/honor-board-block', {
  edit: Edit,
  save: () => null,
});
