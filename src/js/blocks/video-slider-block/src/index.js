import { registerBlockType } from '@wordpress/blocks';
import Edit from './editor';
import '../style/editor.scss';
import '../style/frontend.scss';

registerBlockType('biotropika/video-slider-block', {
  // editor-only UI:
  edit: Edit,
  // fully dynamic — frontend rendered in PHP:
  save: () => null,
});
