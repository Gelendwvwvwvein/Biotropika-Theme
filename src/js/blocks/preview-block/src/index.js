import { registerBlockType } from '@wordpress/blocks';
import Edit from './editor';
import Heading from '../../../../../templates/template-parts/components/Heading.js';
import '../style/editor.scss';
import '../style/frontend.scss';

 registerBlockType('biotropika/preview-block', {
   edit: Edit,
   save({ attributes }) {
     const { title, raceNumber, raceDate } = attributes;
     return (
       <section className="biotropika-preview-block">
         {title      && <Heading level={1} className="preview__title">{title}</Heading>}
         {raceNumber && <p className="preview__race-number">Гонка #{raceNumber}</p>}
         {raceDate   && <p className="preview__date">Дата: {raceDate}</p>}
       </section>
     );
   },
 });