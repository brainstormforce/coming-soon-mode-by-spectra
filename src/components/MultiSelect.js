import React from 'react';
import Select from 'react-select';

const MultiSelect = ({ options = [], value = [], onChange, placeholder = '' }) => {
    const selectOptions = options.map((opt) => ({ value: opt.value, label: opt.label }));
    const selected = selectOptions.filter((opt) => value.includes(opt.value));

    const handleChange = (selectedOptions) => {
        const values = selectedOptions ? selectedOptions.map((o) => o.value) : [];
        onChange(values);
    };

    return (
        <Select
            options={selectOptions}
            value={selected}
            onChange={handleChange}
            isMulti
            placeholder={placeholder}
            closeMenuOnSelect={false}
            classNamePrefix="react-select"
        />
    );
};

export default MultiSelect;
