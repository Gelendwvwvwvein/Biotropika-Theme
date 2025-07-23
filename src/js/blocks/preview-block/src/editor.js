import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import { useState, useEffect } from 'react';

export default function Edit({ attributes, setAttributes }) {
  const { title: attrTitle, raceNumber: attrRaceNumber, raceDate: attrRaceDate } = attributes;

  // Локальный стейт
  const [ title, setTitle ]           = useState(attrTitle || '');
  const [ raceNumber, setRaceNumber ] = useState(attrRaceNumber || '');
  const [ raceDate, setRaceDate ]     = useState(attrRaceDate || '');

  // Синхронизируем локальный стейт, если атрибуты обновились извне
  useEffect(() => setTitle(attrTitle || ''),       [attrTitle]);
  useEffect(() => setRaceNumber(attrRaceNumber || ''), [attrRaceNumber]);
  useEffect(() => setRaceDate(attrRaceDate || ''),     [attrRaceDate]);

  const blockProps = useBlockProps({ className: 'biotropika-preview-block' });

  return (
    <>
      <InspectorControls>
        <PanelBody title={__('Настройки превью', 'biotropika')} initialOpen>
          <TextControl
            label={__('Заголовок', 'biotropika')}
            value={title}
            onChange={val => setTitle(val)}
            onBlur={() => setAttributes({ title })}
            placeholder={__('Введите заголовок', 'biotropika')}
          />
          <TextControl
            label={__('Номер гонки', 'biotropika')}
            value={raceNumber}
            onChange={val => setRaceNumber(val)}
            onBlur={() => setAttributes({ raceNumber })}
            placeholder={__('Например, 25', 'biotropika')}
          />
          <TextControl
            label={__('Дата', 'biotropika')}
            value={raceDate}
            onChange={val => setRaceDate(val)}
            onBlur={() => setAttributes({ raceDate })}
            placeholder={__('ДД.ММ.ГГГГ', 'biotropika')}
          />
        </PanelBody>
      </InspectorControls>

      <div {...blockProps}>
        {title      && <h2 className="preview__title">{title}</h2>}
        {raceNumber && <div className="preview__race-number">Гонка #{raceNumber}</div>}
        {raceDate   && <div className="preview__date">Дата: {raceDate}</div>}
      </div>
    </>
  );
}
